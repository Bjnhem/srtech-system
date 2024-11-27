<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class ErrorExport implements FromArray
{
    protected $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;
    }

    public function array(): array
    {
        // Định dạng dữ liệu để xuất ra Excel
        $errorData = [
            ['Row', 'Error', 'Data'],
        ];

        foreach ($this->errors as $error) {
            $errorData[] = [
                $error['row'],
                $error['error'],
                implode(', ', $error['data']),
            ];
        }

        return $errorData;
    }
}
