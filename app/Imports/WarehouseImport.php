<?php

namespace App\Imports;

use App\Models\warehouse\Warehouse;
use Maatwebsite\Excel\Concerns\ToModel;

class WarehouseImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new warehouse([
            'name' => $row['name'],
            'location' => $row['location'],
            'status' => $row['status'],
        ]);
    }
}
