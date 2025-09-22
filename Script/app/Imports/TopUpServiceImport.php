<?php

namespace App\Imports;

use App\Models\TopUpService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class TopUpServiceImport implements ToCollection
{
    private $topUpId;

    public function __construct($topUpId)
    {
        $this->topUpId = $topUpId;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $value) {
            try {
                if ($key != 0) {
                    TopUpService::firstOrCreate(
                        [
                            'top_up_id' => $this->topUpId,
                            'name' => $value[0],
                        ],
                        [
                            'price' => $value[1],
                            'discount' => $value[2],
                            'discount_type' => $value[3],
                            'status' => $value[4],
                        ]
                    );
                }
            } catch (\Exception  $e) {
                continue;
            }
        }
        return true;
    }
}
