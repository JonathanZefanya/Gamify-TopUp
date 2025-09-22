<?php

namespace App\Exports;

use App\Models\Code;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CodeExport implements FromCollection, WithHeadings
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $dateTimeFormat = basicControl()->date_time_format;

        return Code::where('codeable_type', $this->data['codeable_type'])->where('codeable_id', $this->data['codeable_id'])
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($query) use ($dateTimeFormat) {
                return [
                    'Code' => $query->passcode,
                    'Status' => $query->status == 1 ? 'Active' : 'In-active',
                    'Created At' => dateTime($query->created_at, $dateTimeFormat),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Code',
            'Status',
            'Created At',
        ];
    }
}
