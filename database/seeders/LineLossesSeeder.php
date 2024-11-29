<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LineLossesSeeder extends Seeder
{
    public function run()
    {
        // Lấy danh sách kế hoạch từ bảng `plans`
        $plans = DB::table('plans')->get();

        // Lấy danh sách lỗi từ bảng `error_list`
        $errorList = DB::table('errors_list')->pluck('id')->toArray(); // Lấy ID của lỗi

        // Tạo dữ liệu ngẫu nhiên cho bảng `line_losses`


        foreach ($plans as $plan) {
            $lineLossesData = [];
            // Các khung giờ (a, b, c, d, e)
            $timeSlots = ['a', 'b', 'c', 'd', 'e'];

            foreach ($timeSlots as $timeSlot) {
                // Random số lượng lỗi từ 15 đến 30
                $numErrors = rand(15, 30);

                for ($i = 0; $i < $numErrors; $i++) {
                    $lineLossesData[] = [
                        'plan_id'     => $plan->id, // Liên kết với ID trong bảng plans
                        'error_list_id' => $errorList[array_rand($errorList)], // ID lỗi ngẫu nhiên
                        'Code_ID'     => 'C' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT), // Mã lỗi giả lập
                        'prod_qty'    => $plan->$timeSlot, // Số lượng sản phẩm
                        'remark'      => rand(0, 1) ? 'Minor issue' : 'Major issue', // Ghi chú ngẫu nhiên
                        'NG_qty'      => 1, // Số lượng lỗi
                        'time_slot'   => $timeSlot, // Ca làm việc
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ];
                }
            }
            DB::table('line_losses')->insert($lineLossesData);
        }

        // Insert dữ liệu vào bảng `line_losses`
        DB::table('line_losses')->insert($lineLossesData);
    }
}
