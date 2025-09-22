<?php

namespace App\Imports;

use App\Models\Code;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CodeImport implements ToCollection
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $value) {
            try {
                if ($key != 0) {
                    Code::firstOrCreate(
                        [
                            'codeable_type' => $this->data['codeable_type'],
                            'codeable_id' => $this->data['codeable_id'],
                            'passcode' => $value[0],
                        ],
                        [
                            'status' => $value[1],
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
