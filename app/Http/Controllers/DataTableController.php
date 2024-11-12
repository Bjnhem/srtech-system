<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataTableController extends Controller
{
    public function __construct()
    {
        //return view('login');
    }
    public function index()
    {
        // return view('smart-ver2.admin.data-table.home');
        return view('Checklist_EQM.admin.data-table.home');
    }
    public function table_show($table)
    {
        return view('Checklist_EQM.admin.data-table.table-view', compact('table'));
    }
    public function show(Request $request)
    {
        $table = 'App\\Models\\' . $request->input('table');
        if ($request->ajax()) {
            if (class_exists($table)) {
                $data = $table::all();
                $colum = array_keys($data->first()->getAttributes());
                $colums = array_diff($colum, ['created_at', 'updated_at']);
                $data = $table::select($colums)->orderBy('id', 'desc')->get();

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

    public function list(Request $request)
    {

        $model_name = $request->input('model_tab');

        $path = app_path('Models');
        $modelFile = File::allFiles($path);
        /*  echo $modelFile; */
        $table = [];
        if ($model_name == 'all') {
            foreach ($modelFile as $file) {
                $class = 'App\\Models\\' . pathinfo($file->getFilename(), PATHINFO_FILENAME);
                if (class_exists($class) && is_subclass_of($class, 'Illuminate\Database\Eloquent\Model')) {
                    $model = new $class;
                    $table[] = [
                        'model' => class_basename($class),
                        'table' => $model->getTable(),
                    ];
                }
            }
        } else {
            foreach ($modelFile as $file) {
                $fileName = pathinfo($file->getFilename(), PATHINFO_FILENAME);
                if (stripos($fileName, $model_name) !== false) {
                    $class = 'App\\Models\\' . pathinfo($file->getFilename(), PATHINFO_FILENAME);
                    if (class_exists($class) && is_subclass_of($class, 'Illuminate\Database\Eloquent\Model')) {
                        $model = new $class;
                        $table[] = [
                            'model' => class_basename($class),
                            'table' => $model->getTable(),
                        ];
                    }
                }
            }
        }
        foreach ($modelFile as $file) {
            $fileName = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            if (stripos($fileName, $model_name) !== false) {
                $class = 'App\\Models\\' . pathinfo($file->getFilename(), PATHINFO_FILENAME);
                if (class_exists($class) && is_subclass_of($class, 'Illuminate\Database\Eloquent\Model')) {
                    $model = new $class;
                    $table[] = [
                        'model' => class_basename($class),
                        'table' => $model->getTable(),
                    ];
                }
            }
        }

        return response()->json([
            'data' => $table,
            'status' => 200,
        ]);
    }


    public function update_table(Request $request)
    {
        $table = 'App\Models\\' . $request->input('id');
        // dd($table);
        $validator = Validator::make($request->all(), [
            'csv_file' => [
                'required',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
            ]);
        } else {

            if (Storage::exists("csv/data.csv")) {
                Storage::delete("csv/data.csv");
            };
            $path = $request->file('csv_file')->storeAs('csv', 'data.csv');
            $path_2 = str_replace('\\', '/', storage_path("app/public/" . $path));
            $csv = Reader::createFromPath($path_2, 'r');
            $csv->setHeaderOffset(0);

            foreach ($csv as $record) {
                // dd($record);
                $table::updateOrCreate(
                    ['id' => $record['id']],
                    $record
                );
            }
            Storage::delete($path_2);
            return redirect()->back()->with('success', 'update dữ liệu thành công');
        }
    }

    public function edit_table(Request $request, $model)
    {
        $table = 'App\\Models\\' . $model;
        $models = new $table;
        $tables = $models->getTable();
        $colum = Schema::getColumnListing($tables);

        if ($request->input('action') == 'edit') {
            $data = $request->only($colum);
            $table::where('id', $request->input('id'))->update($data);
            return response()->json($request->all());
        }

        if ($request->input('action') == 'delete') {
            $table::where('id', $request->input('id'))->delete();
            return response()->json($request->all());
        }
    }

    public function new_row(Request $request)
    {
        $table = 'App\Models\\' . $request->input('table');
        if ($request->ajax()) {
            if (class_exists($table)) {
                $data = $table::all();
                $colum = array_keys($data->first()->getAttributes());
                $colums = array_diff($colum, ['created_at', 'create_at', 'updated_at', 'update_at']);

                $models = new $table;
                foreach ($colum as $column) {
                    $models->$column = '';
                }
                $models->save();
                $data = $table::select($colums)->orderBy('id', 'DESC')->get();

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

    public function delete_row(Request $request)
    {
        $table = 'App\Models\\' . $request->input('table');
        $row_id_delete = $request->input('rowId');
        if ($request->ajax()) {
            if (class_exists($table)) {

                $table::whereIn('id', $row_id_delete)->delete();
                $data = $table::all();
                $colum = array_keys($data->first()->getAttributes());
                $colums = array_diff($colum, ['created_at', 'updated_at']);
                $data = $table::select($colums)->orderBy('id', 'DESC')->get();

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


    public function findModel($table)
    {

        $modelNamespace = 'App\Models';
        $models = collect(get_declared_classes())->filter(function ($class) use ($modelNamespace) {
            return strpos($class, $modelNamespace) === 0 && is_subclass_of($class, Model::class);
        });

        $matchingModel = $models->first(function ($model) use ($table) {
            $refectionClass = new ReflectionClass($model);
            $modelTable = $refectionClass->getProperty('table')->getValue();
            return $modelTable === $table;
        });

        return $matchingModel ?? null;
    }
}
