<?php

namespace App\Exports;

use App\Models\TopUpService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TopUpServiceExport implements FromCollection, WithHeadings
{
    private $search;

    public function __construct($request)
    {
        $this->search = $request;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $currency = basicControl()->base_currency;
        $dateTimeFormat = basicControl()->date_time_format;

        return TopUpService::where('top_up_id', $this->search['topUp'])
            ->orderBy('sort_by', 'asc')
            ->get()
            ->map(function ($query) use ($currency, $dateTimeFormat) {
                $discount = $query->getDiscount();
                $discountType = $query->discount_type == 'flat' ? $currency : '%';

                return [
                    'Service Name' => $query->name,
                    'Price' => formatAmount($query->price - $discount) . ' ' . $currency,
                    'Discount' => $query->discount . ' ' . $discountType,
                    'Discount Amount' => formatAmount($discount) . ' ' . $currency,
                    'Status' => $query->status == 1 ? 'Active' : 'In-active',
                    'Created At' => dateTime($query->created_at, $dateTimeFormat),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Service Name',
            'Price',
            'Discount',
            'Discount Amount',
            'Status',
            'Created At',
        ];
    }

}
