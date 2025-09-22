<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\CardService;
use App\Models\TopUpService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CampaignCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:campaign-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Campaign is running or not';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $campaign = Campaign::firstOrNew();
        $today = Carbon::now();

        $topUpServices = TopUpService::whereNotNull('old_data')->orWhere('is_offered',1)->get();
        $this->applyCampaign($campaign, $topUpServices, $today);


        $cardServices = CardService::whereNotNull('old_data')->orWhere('is_offered',1)->get();
        $this->applyCampaign($campaign, $cardServices, $today);

    }

    protected function applyCampaign($campaign, $services, $today)
    {
        if ($campaign->status && $campaign->start_date <= $today && $campaign->end_date >= $today) {
            if (!empty($services)) {
                foreach ($services as $service) {
                    if($service->is_offered){
                        $this->oldDataStore($service);

                        if ($service->max_sell >= $service->offered_sell) {
                            $service->price = $service->campaign_data->price ?? $service->price;
                            $service->discount = $service->campaign_data->discount ?? $service->discount;
                            $service->discount_type = $service->campaign_data->discount_type ?? $service->discount_type;
                            $service->max_sell = $service->campaign_data->max_sell ?? $service->max_sell;

                            $service->is_offered = 1;
                            $service->save();
                        } else {
                            $this->setActualData($service);

                            $service->old_data = null;
                            $service->campaign_data = null;
                            $service->is_offered = 0;
                            $service->save();
                        }
                    }else{
                        $this->setActualData($service);

                        $service->old_data = null;
                        $service->campaign_data = null;
                        $service->is_offered = 0;
                        $service->save();
                    }
                }
            }
        } elseif ($campaign->end_date <= $today) {
            if (!empty($services)) {
                foreach ($services as $service) {

                    $this->setActualData($service);

                    $service->offered_sell = 0;
                    $service->old_data = null;
                    $service->campaign_data = null;
                    $service->is_offered = 0;
                    $service->save();
                }
            }
        } else {
            if (!empty($services)) {
                foreach ($services as $service) {
                    $this->setActualData($service);
                }
            }
        }

        return true;
    }

    protected function setActualData($service)
    {
        $service->price = $service->old_data->price ?? $service->price;
        $service->discount = $service->old_data->discount ?? $service->discount;
        $service->discount_type = $service->old_data->discount_type ?? $service->discount_type;
        $service->max_sell = $service->campaign_data->max_sell ?? $service->max_sell;

        $service->save();
    }

    protected function oldDataStore($service): void
    {
        if (!$service->old_data) {
            $oldData = [
                'price' => $service->price,
                'discount' => $service->discount,
                'discount_type' => $service->discount_type,
            ];

            $service->old_data = $oldData;
            $service->save();
        }
    }
}
