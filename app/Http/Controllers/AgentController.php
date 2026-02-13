<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AgentService;
use App\Models\UserCompany;
use Illuminate\Support\Facades\Auth;
use App\Models\TourCalculation;

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

       return redirect('/')->with('success', 'Logged out successfully!');
    }
    
    public function profile()
    {
        $user = Auth::user();
        $company = UserCompany::where('user_id', $user->id)->first();
    
        return view('agent.profile', compact('user', 'company'));
    }

    public function calculation_report(Request $request)
    {
        $user = Auth::user();
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $reports = $this->service->get_calculation_report($user->id, $startDate, $endDate);
        $stats = $this->service->getActivityStats($user->id);

        return view('agent.package_calculator_report', compact('reports', 'stats', 'startDate', 'endDate'));
    }
    
    
   public function company_profile()
    {
        $user = Auth::user();
    
        // logged-in user ki company
        $company = UserCompany::where('user_id', $user->id)->first();
    
        return view('agent.update_profile', compact('user', 'company'));
    }
    
    public function update(Request $request)
{
    $request->validate([
        'company_name' => 'required|string|max:255',
        'email'        => 'required|email',
        'mobile'       => 'required|string|max:15',
        'address'      => 'nullable|string',
        'city'         => 'nullable|string',
        'state'        => 'nullable|string',
        'country'      => 'nullable|string',
        'pincode'      => 'nullable|string|max:10',
        'gst_number'   => 'nullable|string|max:20',
        'pan_number'   => 'nullable|string|max:20',
        'logo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $user = Auth::user();

    // user ka company record lo ya naya banao
    $company = UserCompany::updateOrCreate(
        ['user_id' => $user->id],
        $request->except('logo')
    );

    // logo upload
    if ($request->hasFile('logo')) {
        $logoPath = $request->file('logo')->store('company_logos', 'public');
        $company->logo = $logoPath;
        $company->save();
    }

    return redirect()
        ->route('agent.company.profile')
        ->with('success', 'Company profile updated successfully');
    }

    public function my_target()
    {
        $user = Auth::user();
        if ($user->role !== 'Staff') {
            return redirect()->route('agent.dashboard')->with('error', 'Access denied.');
        }

        $targetData = $this->service->getTargetData($user->id);

        return view('agent.target', compact('user', 'targetData'));
    }
    
    

    public function show($id)
    {
      $calculation = TourCalculation::findOrFail($id);
      return view('agent.package_calculator_show', compact('calculation'));
    }

}