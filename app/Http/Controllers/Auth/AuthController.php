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

class AuthController extends Controller
{
   
    public function showLogin()
    {
        return view('auth.login');
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
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Welcome back, ' . auth()->user()->name . '!');
        }

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
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'mobile'    => '',     
            'role'      => 'Agent',              
            'status'    => 1,                   
            'is_verify' => 0,                    
            'password'  => Hash::make($request->password),
        ]);

       Auth::login($user);
        return redirect()->route('login')
            ->with('success', 'Account created successfully! Welcome, ' . $user->name . '!');
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
        $users = User::active()->get();
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