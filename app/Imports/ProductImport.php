<?php

namespace App\Imports;

use App\Models\WareHouse\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    /**
     * Map các cột từ file Excel vào model Product.
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Kiểm tra dữ liệu có đủ các trường cần thiết không
        if (empty($row[0]) || empty($row[1])) { // Ví dụ: Cột 0 là name, cột 5 là sku
            return null; // Bỏ qua dòng này nếu thiếu dữ liệu
        }

        return new Product([
            'Type'        => $row[0] ?? null,  // Cột đầu tiên là name
            'name'        => $row[1] ?? null,  // Cột Type
            'Code_Purchase'     => $row[2] ?? null,  // Cột Part_ID
            'ID_SP' => $row[3] ?? null, // Cột Code_Purchase
            'Part_ID'       => $row[4] ?? null,  // Cột ID_SP
            'Model'       => $row[5] ?? null,
            'vendor'      => $row[6] ?? null,
            'version'     => $row[7] ?? null,
            'stock_limit' => $row[8] ?? null,
            'Image'       => $row[9] ?? null,
        ]);
    }
}
