<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Import model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Untuk hashing password
use Illuminate\Validation\Rule; // Untuk validasi unique email pada update

class UserController extends Controller
{
    /**
     * Display a listing of the resource (users).
     */
    public function index()
    {
        $users = User::latest()->paginate(10); // Ambil semua user, urutkan terbaru, paginate
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource (user).
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource (user) in storage.
     */
    public function store(Request $request)
    {
        // Validasi input untuk pembuatan user baru
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email', // Email harus unik
            'password' => 'required|string|min:8|confirmed', // Password minimal 8 karakter dan harus dikonfirmasi
        ]);

        // Hash password sebelum menyimpan
        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Display the specified resource (user).
     * Tidak relevan untuk admin panel, biasanya redirect ke halaman edit atau daftar.
     */
    public function show(User $user)
    {
        return redirect()->route('admin.users.edit', $user);
    }

    /**
     * Show the form for editing the specified resource (user).
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource (user) in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validasi input untuk update user
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // Email harus unik kecuali email dari user yang sedang diedit
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed', // Password bisa nullable (tidak diubah)
        ]);

        // Hanya update password jika ada input password baru
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            // Hapus password dari data yang akan diupdate jika tidak diubah
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui!');
    }

    /**
     * Remove the specified resource (user) from storage.
     */
    public function destroy(User $user)
    {
        // Pencegahan: Opsional, agar admin tidak bisa menghapus akunnya sendiri
        // if ($user->id === auth()->id()) {
        //     return redirect()->route('admin.users.index')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        // }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}
