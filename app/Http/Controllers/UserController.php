<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Models\User;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{

    public function index_user()
    {
        return view('srtech.users.user-index');
    }

    public function show_data_table(Request $request)
    {
        $table = 'App\Models\\' . $request->input('table');
        if ($request->ajax()) {
            if (class_exists($table)) {
                $data = $table::all();
                $colum = array_keys($data->first()->getAttributes());
                $colums = array_diff($colum, ['created_at', 'updated_at']);
                $data = $table::select($colums)->orderBy('id', 'asc')->get();

                return response()->json([
                    'data' => $data,
                    'colums' => $colums,
                    'status' => 200,
                ]);
            }
            return abort(404);
        }
        return abort(404);
    }


    public function delete_data_row_table(Request $request)
    {
        $table = 'App\Models\\' . $request->input('table');
        $id = $request->input('id_row');
        if ($request->ajax()) {
            if (class_exists($table)) {
                $table::where('id', $id)->delete();
                $data = $table::all();

                return response()->json([
                    'data' => $data,
                    'status' => 200,
                ]);
            }
            return abort(404);
        }
        return abort(404);
    }

    public function add_data_row_table(Request $request)
    {
        $id = $request->input('id', null);
        if ($request->ajax()) {
            // Kiểm tra nếu tồn tại ID để xử lý cập nhật
            $user = User::find($id);

            if ($user) {
                // Nếu có dữ liệu người dùng, thực hiện cập nhật
                if (!empty($request->password)) {
                    $user->password = Hash::make($request->password);
                }
                $user->update([
                    'username' => $request->username,
                    'part' => $request->part,
                    'email' => $request->username . '@gmail.com',
                    'user_type' => $request->user_type,
                    'status' => $request->status,
                ]);
            } else {
                // Nếu không tồn tại, thực hiện tạo mới với xác thực dữ liệu
                $validatedData = $request->validate([
                    'part' => 'required|string|max:255',
                    'username' => 'required|string|max:255|unique:users,username',
                    'password' => 'required|string|confirmed|min:4',
                ]);

                User::create([
                    'username' => $request->username,
                    'part' => $request->part,
                    'email' => $request->username . '@gmail.com',
                    'password' => Hash::make($validatedData['password']),
                    'user_type' => $request->user_type,
                    'status' => $request->status,
                ]);
            }

            return response()->json([
                'status' => 200,
                'success' => 'Thành công!'
            ]);
        }

        return response()->json([
            'status' => 404,
            'error' => 'Không thành công'
        ]);
    }


}
