<?php

namespace App\Imports;

use App\Models\OQC\Plan; // Import model của bạn nếu cần thiết
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Nếu file của bạn có header
use Maatwebsite\Excel\Concerns\WithValidation; // Nếu bạn muốn validate dữ liệu
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PlansImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
{
    $date = $this->convertExcelDate($row['date']);

    // Kiểm tra lại giá trị ngày tháng
    if (Carbon::parse($date)->isValid()) {
        return new Plan([
            'date' => $date,
            'shift' => $row['shift'],
            'line' => $row['line'],
            'model' => $row['model'],
            'prod' => $row['prod'],
            'a' => $row['a'],
            'b' => $row['b'],
            'c' => $row['c'],
            'd' => $row['d'],
            'e' => $row['e'],
        ]);
    }

    // Nếu ngày tháng không hợp lệ, báo lỗi hoặc bỏ qua dòng dữ liệu
    return null;  // Hoặc throw new \Exception("Invalid date value: " . $date);
}


    public function rules(): array
    {
        // Nếu bạn muốn validate dữ liệu, bạn có thể thêm các điều kiện validate ở đây
        return [
            'date' => 'required|date',
            'shift' => 'required|in:A,C',
            'line' => 'required|string',
            'model' => 'required|string',
            'prod' => 'required|integer',
            'a' => 'required|integer',
            'b' => 'required|integer',
            'c' => 'required|integer',
            'd' => 'required|integer',
            'e' => 'required|integer',
        ];
    }

    // Hàm chuyển đổi ngày Excel (số) thành định dạng 'YYYY-MM-DD'
    private function convertExcelDate($excelDate)
    {
        if (is_numeric($excelDate)) {
            // Chuyển đổi số ngày Excel thành đối tượng DateTime và định dạng theo 'YYYY-MM-DD'
            $dateTime = Date::excelToDateTimeObject($excelDate);
            // dd($dateTime); // Kiểm tra giá trị trả về từ hàm này

            return Carbon::instance($dateTime)->format('Y-m-d');
        }

        // Nếu giá trị ngày đã đúng định dạng, trả lại như cũ
        return $excelDate;
    }
}
