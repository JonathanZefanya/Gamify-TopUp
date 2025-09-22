<?php

namespace App\Http\Controllers\Admin\Module;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CardService;
use App\Models\TopUpService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function view()
    {
        $data['campaign'] = Campaign::firstOrNew();

        $data['topUpServices'] = TopUpService::select(['id', 'name', 'image', 'image_driver', 'status', 'sort_by', 'is_offered'])
            ->where('status', 1)->orderBy('sort_by', 'ASC')->get();

        $data['cardServices'] = CardService::select(['id', 'name', 'image', 'image_driver', 'status', 'sort_by', 'is_offered'])
            ->where('status', 1)->orderBy('sort_by', 'ASC')->get();

        return view('admin.campaign.view', $data);
    }

    public function getTopUpService(Request $request)
    {
        $offeredTopUpServices = TopUpService::whereIn('id', $request->selectedIds)->where('status', 1)
            ->orderBy('sort_by', 'ASC')->get()->map(function ($query) {
                $query->price = $query->campaign_data->price ?? $query->price;
                $query->discount = $query->campaign_data->discount ?? $query->discount;
                $query->discount_type = $query->campaign_data->discount_type ?? $query->discount_type;
                $query->max_sell = $query->campaign_data->max_sell ?? $query->max_sell;

                return $query;
            });
        return response()->json(['status' => true, 'offerServices' => $offeredTopUpServices]);
    }

    public function getCardService(Request $request)
    {
        $offeredCardServices = CardService::whereIn('id', $request->selectedIds)->where('status', 1)
            ->orderBy('sort_by', 'ASC')->get()->map(function ($query) {
                $query->price = $query->campaign_data->price ?? $query->price;
                $query->discount = $query->campaign_data->discount ?? $query->discount;
                $query->discount_type = $query->campaign_data->discount_type ?? $query->discount_type;
                $query->max_sell = $query->campaign_data->max_sell ?? $query->max_sell;

                return $query;
            });
        return response()->json(['status' => true, 'offerServices' => $offeredCardServices]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'date' => 'required',
        ]);

        $filterDate = explode('to', $request->date);
        $startDate = $filterDate[0];
        $endDate = isset($filterDate[1]) ? trim($filterDate[1]) : null;

        $campaign = Campaign::firstOrNew();
        $campaign->name = $request->name;
        $campaign->start_date = Carbon::parse($startDate);
        $campaign->end_date = Carbon::parse($endDate);
        $campaign->status = $request->status;
        $campaign->save();

        //Top Up
        $allTopUpServices = TopUpService::where('status', 1)->get();

        $topUpServicesToOffer = $allTopUpServices->whereIn('id', $request->topups);
        $topUpServicesNotOffered = $allTopUpServices->whereNotIn('id', $request->topups);

        TopUpService::whereIn('id', $topUpServicesNotOffered->pluck('id'))->update(['is_offered' => 0]);

        foreach ($topUpServicesToOffer as $service) {
            $this->campaignDataStore($service, $request->topup_price[$service->id], $request->topup_discount[$service->id],
                $request->topup_discount_type[$service->id], $request->topup_max_sell[$service->id]);

            $service->is_offered = 1;
            $service->save();
        }

        //Card
        $allCardServices = CardService::where('status', 1)->get();

        $cardServicesToOffer = $allCardServices->whereIn('id', $request->cards);
        $cardServicesNotOffered = $allCardServices->whereNotIn('id', $request->cards);

        CardService::whereIn('id', $cardServicesNotOffered->pluck('id'))->update(['is_offered' => 0]);

        foreach ($cardServicesToOffer as $service) {
            $this->campaignDataStore($service, $request->card_price[$service->id], $request->card_discount[$service->id],
                $request->card_discount_type[$service->id], $request->card_max_sell[$service->id]);

            $service->is_offered = 1;
            $service->save();
        }

        return back()->with('success', 'Campaign Updated Successfully');
    }


    protected function campaignDataStore($service, $price, $discount, $discount_type, $max_sell): void
    {
        $campaignData = [
            'price' => $price,
            'discount' => $discount,
            'discount_type' => $discount_type,
            'max_sell' => $max_sell,
        ];

        $service->campaign_data = $campaignData;
        $service->save();
    }
}
