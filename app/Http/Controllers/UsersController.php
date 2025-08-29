<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

use function Laravel\Prompts\password;

class UsersController extends Controller
{
    public function index(Request $request): View
    {
        // $users = User::orderBy('created_at', 'desc')->get();
        $search = $request->query('q');

        $users = User::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('role', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('user', compact('users'));
    }

    // Tampilkan form edit user
    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    // Update data user
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('user')->with('status', 'User Updated');
    }

    public function passwordUpdate(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('user')->with('status', 'Password Updated');
    }

    // Hapus user
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('user')->with('destroy', 'User Deleted');
    }

   public function create(): View
   {
    return view('users.create');
   }

   public function store(Request $request, User $user): RedirectResponse
   {

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|lowercase|unique:users,email,' . $user->id,
        'password' => 'required|string|min:8|confirmed',
        'role' => 'nullable|string|in:user,admin',
    ]);

    $user->create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password'] ?? 'password'),
        'role' => $validated['role'] ?? 'user',
    ]);

    return redirect()->route('user')->with('status', 'User Added');
   }

    public function autocomplete(Request $request)
    {
        $q = trim($request->query('q', ''));
        if ($q === '' || mb_strlen($q) < 1) {
            return response()->json([]);
        }

        $results = User::query()
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%')
                      ->orWhere('email', 'like', '%' . $q . '%');
            })
            ->orderBy('name')
            ->limit(8)
            ->get(['id', 'name', 'email', 'role']);

        return response()->json($results);
    }

    
}
