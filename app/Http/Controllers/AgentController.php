<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AgentService;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
     protected $service;

    public function __construct(AgentService $service)
    {
        $this->middleware('agent');
        $this->service = $service;
    }

    public function dashboard()
    {
        $user = Auth::user();
        $counts = $this->service->tourCounts($user->id);

        return view('agent.dashboard', compact('user','counts'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }



    public function calculation_report()
    {
        $user = Auth::user();
        $reports = $this->service->get_calculation_report($user->id);

        return view('agent.package_calculator_report', compact('reports'));
    }
}