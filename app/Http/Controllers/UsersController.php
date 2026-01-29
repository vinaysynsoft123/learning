<?php


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    // 🔹 List users
    public function index()
    {
        $users = User::latest()->get();
        return view('users.index', compact('users'));
    }

    // 🔹 Show create form
    public function create()
    {
        return view('users.create');
    }

    // 🔹 Store new user
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required',
            'status'   => 'required|in:0,1',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'status'    => $request->status,
            'is_verify' => $request->has('is_verify') ? 1 : 0,
        ]);

        return redirect()->route('users.index')->with('success', 'User created');
    }

    // 🔹 Edit user (IMPORTANT)
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // 🔹 Update user (YOUR ERROR WAS HERE)
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'mobile'   => 'nullable|string|max:15',
            'role'     => 'required|string',
            'status'   => 'required|in:0,1',
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

        return redirect()->route('users.index')->with('success', 'User updated');
    }

    // 🔹 Delete user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted');
    }

public function show(User $user)
{
    $user->load('company');
    return view('users.show', compact('user'));
}


}
