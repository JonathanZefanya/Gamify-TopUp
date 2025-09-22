<?php

namespace App\Imports;

use App\Models\CardService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CardServiceImport implements ToCollection
{
    private $cardId;

    public function __construct($cardId)
    {
        $this->cardId = $cardId;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $value) {
            try {
                if ($key != 0) {
                    CardService::firstOrCreate(
                        [
                            'card_id' => $this->cardId,
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
