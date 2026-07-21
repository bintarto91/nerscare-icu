<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $this->ensureAdmin();

        $search = $request->get('search');
        $role = $request->get('role');

        $users = User::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($role, function ($query) use ($role) {
                $query->where('role', $role);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users', 'search', 'role'));
    }

    public function create()
    {
        $this->ensureAdmin();

        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $rules = [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'role' => ['required', Rule::in(['admin', 'perawat', 'keluarga'])],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];

        if (Schema::hasColumn('users', 'unit_kerja')) {
            $rules['unit_kerja'] = ['nullable', 'string', 'max:150'];
        }

        if (Schema::hasColumn('users', 'status')) {
            $rules['status'] = ['required', Rule::in(['aktif', 'nonaktif'])];
        }

        $validated = $request->validate($rules);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ];

        if (Schema::hasColumn('users', 'unit_kerja')) {
            $data['unit_kerja'] = $validated['unit_kerja'] ?? null;
        }

        if (Schema::hasColumn('users', 'status')) {
            $data['status'] = $validated['status'];
        }

        User::create($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $this->ensureAdmin();

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->ensureAdmin();

        $rules = [
            'name' => ['required', 'string', 'max:150'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role' => ['required', Rule::in(['admin', 'perawat', 'keluarga'])],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ];

        if (Schema::hasColumn('users', 'unit_kerja')) {
            $rules['unit_kerja'] = ['nullable', 'string', 'max:150'];
        }

        if (Schema::hasColumn('users', 'status')) {
            $rules['status'] = ['required', Rule::in(['aktif', 'nonaktif'])];
        }

        $validated = $request->validate($rules);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        if (Schema::hasColumn('users', 'unit_kerja')) {
            $data['unit_kerja'] = $validated['unit_kerja'] ?? null;
        }

        if (Schema::hasColumn('users', 'status')) {
            $data['status'] = $validated['status'];
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $this->ensureAdmin();

        if ($user->id === auth()->id()) {
            return redirect()
                ->route('users.index')
                ->withErrors('Akun yang sedang login tidak boleh dihapus.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    private function ensureAdmin(): void
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
    }
}