<?php

namespace App\Http\Controllers\OQC;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PlansImport;

use App\Http\Controllers\Controller;
use App\Models\OQC\Plan;
use Illuminate\Http\Request;

class OQCController extends Controller
{
   
    
    public function import(Request $request)
    {
        $file = $request->file('file');
        Excel::import(new PlansImport, $file);
    
        return redirect()->route('plans.index')->with('success', 'Kế hoạch đã được tải lên thành công!');
    }
    
    public function index(Request $request)
    {
        $search = $request->input('search');
        $plans = Plan::where('model', 'like', "%{$search}%")
            ->orWhere('line', 'like', "%{$search}%")
            ->paginate(10);
    
        return view('plans.index', compact('plans', 'search'));
    }
    
    public function edit(Plan $plan)
    {
        return view('plans.edit', compact('plan'));
    }
    
    public function update(Request $request, Plan $plan)
    {
        $plan->update($request->all());
        return redirect()->route('plans.index')->with('success', 'Kế hoạch đã được cập nhật thành công!');
    }
    
    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('plans.index')->with('success', 'Kế hoạch đã được xóa thành công!');
    }
    
}
