<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('status', 'approved')->latest()->get();
        $pendingUsers = User::where('status', 'pending')->latest()->get();

        return view('dataPengguna', compact('users', 'pendingUsers'));
    }

    public function create()
    {
        return view('createPengguna');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_depan' => 'required|string|max:255',
            'nama_belakang' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'instansi' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'role' => 'required|in:admin,kadis',
            'password' => 'required|min:6',
        ]);

        User::create([
            'nama_depan' => $validated['nama_depan'],
            'nama_belakang' => $validated['nama_belakang'],
            'username' => $validated['username'],
            'instansi' => $validated['instansi'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status' => 'approved',
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('dataPengguna')
            ->with('success', 'Data pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('editPengguna', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama_depan' => 'required',
            'nama_belakang' => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'instansi' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,kadis',
            'password' => 'nullable|min:6',
        ]);

        $user->update([
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'username' => $request->username,
            'instansi' => $request->instansi,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if (!empty($request->password)) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()
            ->route('dataPengguna')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()
            ->route('dataPengguna')
            ->with('success', 'Data pengguna berhasil dihapus.');
    }

    public function approve(User $user)
    {
        $user->update(['status' => 'approved']);

        return redirect()
            ->route('dataPengguna')
            ->with('success', "Registrasi pengguna {$user->username} berhasil disetujui.");
    }

    public function reject(User $user)
    {
        $username = $user->username;
        $user->delete();

        return redirect()
            ->route('dataPengguna')
            ->with('success', "Registrasi pengguna {$username} berhasil ditolak.");
    }
}