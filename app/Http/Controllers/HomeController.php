<?php

namespace App\Http\Controllers;

use App\Models\Checklist_result;
use App\Models\line;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /*
     * Dashboard Pages Routs
     */

    public function Home_index()
    {

        return view('ilsung.pages.Home.Home_index');
        // return view('ilsung.pages.Overview-checklist');
    }

    public function Home_checklist()
    {

        // return view('ilsung.pages.Home.Home_index');
        return view('ilsung.pages.Overview-checklist');
    }

    public function Home_WareHouse()
    {

        // return view('ilsung.pages.Home.Home_index');
        return view('ilsung.WareHouse.pages.Overview');
    }

    public function Home_OQC()
    {

        // return view('ilsung.pages.Home.Home_index');
        return view('ilsung.pages.OQC.Home_index');
    }



    public function home_checklist_overview(Request $request)
    {
        $assets = ['calender', 'animation'];
        $line_search = 'Line 01';
        $line_id = Line::where('Line_name', $line_search)->pluck('id')->first();
        return view('ilsung.dashboards.Home_index', compact('assets', 'line_id'));
    }



    public function index_checklist()
    {

        $line_search = 'Line 01';
        $assets = [ 'animation'];
        $line_id = line::where('Line_name', $line_search)->pluck('id')->first();
        return view('ilsung.pages.Check-checklist', compact('line_id', 'assets'));
    }



    public function index_user()
    {
        return view('Checklist_EQM.pages.User-checklist');
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

    /*
     * Menu Style Routs
     */
    public function horizontal(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.horizontal', compact('assets'));
    }
    public function dualhorizontal(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.dual-horizontal', compact('assets'));
    }
    public function dualcompact(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.dual-compact', compact('assets'));
    }
    public function boxed(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.boxed', compact('assets'));
    }
    public function boxedfancy(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.boxed-fancy', compact('assets'));
    }

    /*
     * Pages Routs
     */
    public function billing(Request $request)
    {
        return view('special-pages.billing');
    }

    public function calender(Request $request)
    {
        $assets = ['calender'];
        return view('special-pages.calender', compact('assets'));
    }

    public function kanban(Request $request)
    {
        return view('special-pages.kanban');
    }

    public function pricing(Request $request)
    {
        return view('special-pages.pricing');
    }

    public function rtlsupport(Request $request)
    {
        return view('special-pages.rtl-support');
    }

    public function timeline(Request $request)
    {
        return view('special-pages.timeline');
    }


    /*
     * Widget Routs
     */
    public function widgetbasic(Request $request)
    {
        return view('widget.widget-basic');
    }
    public function widgetchart(Request $request)
    {
        $assets = ['chart'];
        return view('widget.widget-chart', compact('assets'));
    }
    public function widgetcard(Request $request)
    {
        return view('widget.widget-card');
    }

    /*
     * Maps Routs
     */
    public function google(Request $request)
    {
        return view('maps.google');
    }
    public function vector(Request $request)
    {
        return view('maps.vector');
    }

    /*
     * Auth Routs
     */
    public function signin(Request $request)
    {
        return view('auth.login');
    }
    public function signup(Request $request)
    {
        return view('auth.register');
    }
    public function confirmmail(Request $request)
    {
        return view('auth.confirm-mail');
    }
    public function lockscreen(Request $request)
    {
        return view('auth.lockscreen');
    }
    public function recoverpw(Request $request)
    {
        return view('auth.recoverpw');
    }
    public function userprivacysetting(Request $request)
    {
        return view('auth.user-privacy-setting');
    }

    /*
     * Error Page Routs
     */

    public function error404(Request $request)
    {
        return view('errors.error404');
    }

    public function error500(Request $request)
    {
        return view('errors.error500');
    }
    public function maintenance(Request $request)
    {
        return view('errors.maintenance');
    }

    /*
     * uisheet Page Routs
     */
    public function uisheet(Request $request)
    {
        return view('uisheet');
    }

    /*
     * Form Page Routs
     */
    public function element(Request $request)
    {
        return view('forms.element');
    }

    public function wizard(Request $request)
    {
        return view('forms.wizard');
    }

    public function validation(Request $request)
    {
        return view('forms.validation');
    }

    /*
     * Table Page Routs
     */
    public function bootstraptable(Request $request)
    {
        return view('table.bootstraptable');
    }

    public function datatable(Request $request)
    {
        return view('table.datatable');
    }

    /*
     * Icons Page Routs
     */

    public function solid(Request $request)
    {
        return view('icons.solid');
    }

    public function outline(Request $request)
    {
        return view('icons.outline');
    }

    public function dualtone(Request $request)
    {
        return view('icons.dualtone');
    }

    public function colored(Request $request)
    {
        return view('icons.colored');
    }

    /*
     * Extra Page Routs
     */
    public function privacypolicy(Request $request)
    {
        return view('privacy-policy');
    }
    public function termsofuse(Request $request)
    {
        return view('terms-of-use');
    }
}
