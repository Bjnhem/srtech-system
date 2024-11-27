<?php

namespace App\Imports;

use App\Models\OQC\ErrorList;
use Maatwebsite\Excel\Concerns\ToModel;



class ErrorListImport implements ToModel
{
    public function model(array $row)
    {
        return new ErrorList([
            'category' => $row['category'],
            'name' => $row['name'],
            'remark' => $row['remark'],
        ]);
    }
}
