<?php

namespace App\Http\Controllers\checklist;

use App\Http\Controllers\Controller;
use App\Models\Checklist_result;
use App\Models\line;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeChecklistController extends Controller
{
    public function index_checklist()
    {

        $line_search = 'Line 01';
        $assets = [ 'animation'];
        $line_id = line::where('Line_name', $line_search)->pluck('id')->first();
        return view('ilsung.pages.Check-checklist', compact('line_id', 'assets'));
    }

    public function index_master()
    {
        return view('ilsung.pages.update_master.index-data');
    }


    public function index_user()
    {
        return view('ilsung.pages.User-checklist');
    }

    public function index_plan()
    {
        $assets = ['calender'];
        return view('ilsung.pages.Plan-checklist', compact('assets'));
    }

    public function overview_data(Request $request)
    {
        $shift = ($request->input('shift') == 'All') ? null : $request->input('shift');
        $line = ($request->input('line') == '') ? null : $request->input('line');
        $date_form = $request->input('date_form');
        $progressData = Checklist_result::select(
            'Locations',
            \DB::raw('COUNT(*) as total_items'),
            \DB::raw('SUM(CASE WHEN Check_status = "Completed" THEN 1 ELSE 0 END) as completed_count')
        )
            ->where('Shift', 'LIKE', '%' . $shift . '%')
            ->where('Locations', 'LIKE', '%' . $line . '%')
            ->where('Date_check', $date_form)
            ->groupBy('Locations')
            ->get()
            ->map(function ($item) {
                $item->completion_percentage = $item->total_items > 0 ? round((($item->completed_count / $item->total_items) * 100), 0) : 0;
                return $item;
            });

        $totalChecklists = $progressData->sum('total_items');
        $completedChecklists = $progressData->sum('completed_count');

        return response()->json([
            'progressData' => $progressData,
            'total_checklists' => $totalChecklists,
            'completed_checklists' => $completedChecklists,
        ]);
    }
}
