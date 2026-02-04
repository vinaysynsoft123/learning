<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterAgent;


class AuthController extends Controller
{
   
    public function showLogin()
    {
        return view('auth.login');
    }

  public function agent_login()
    {
        return view('auth.agent_login');
    }


 public function login(Request $request)
{
   
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
      
        $request->session()->regenerate();

        $user = auth()->user();
       
        if ($user->role === 'Admin') {
            return redirect()->route('dashboard')
                ->with('success', 'Welcome back, ' . $user->name . '!');
        } elseif (in_array($user->role, ['Agent', 'Staff', 'Freelancer'])) {
            return redirect()->route('agent.dashboard')
                ->with('success', 'Welcome back, ' . $user->name . '!');
        } else {
            // Optional: handle other roles
            Auth::logout();
            return back()
                ->withErrors(['email' => 'Unauthorized role.'])
                ->with('error', 'You do not have access to login.');
        }
    }

    // 🔹 Login failed
    return back()
        ->withErrors(['email' => 'Invalid email or password.'])
        ->with('error', 'Login failed. Please check your credentials.')
        ->onlyInput('email');
}


    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:8|confirmed',
            'mobile'   => 'required|digits:10|regex:/^[6-9]\d{9}$/|unique:users,mobile',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'mobile'    => $request->mobile, 
            'role'      => 'Agent',              
            'status'    => 1,                   
            'is_verify' => 0,                    
            'password'  => Hash::make($request->password),
        ]);

       Mail::to($user->email)->send(new RegisterAgent($user));
       return redirect('/')->with('success', 'Register successfully');
        
    }


 public function dashboard(DashboardService $dashboardService)
    {
        $counts = $dashboardService->masterCounts();

        return view('dashboard', compact('counts'));
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out.');
    }


    public function user_list()
    {
        $users = User::where('role','!=','Admin')->active()->get();
        return view('users.index', compact('users'));
    }

   public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|max:255|unique:users,email,' . $user->id,
            'mobile' => 'nullable|string|max:15',
            'role'   => 'required|string',
            'status' => 'required|in:0,1',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $data = $request->only([
            'name',
            'email',
            'mobile',
            'role',
            'status',
        ]);

        $data['is_verify'] = $request->has('is_verify') ? 1 : 0;

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users')->with('success', 'User updated');
    }

}