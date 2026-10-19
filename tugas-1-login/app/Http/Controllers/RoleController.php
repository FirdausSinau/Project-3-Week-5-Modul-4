<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeRoleRequest;
use App\Models\User;
use App\Services\RoleManagementService;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    /**
     * Tampilkan daftar pengguna yang role-nya dapat diubah.
     */
    public function index()
    {
        $users = User::whereIn('role', ['customer', 'staff'])
            ->orderBy('username')
            ->get();

        return view('admin.users', compact('users'));
    }

    /**
     * Ubah role pengguna melalui service.
     */
    public function update(
        ChangeRoleRequest $request,
        User $user,
        RoleManagementService $service
    ): RedirectResponse {
        $data = $request->validated();
        $service->changeRole($request->user(), $user, $data['role']);

        return back()->with('status', 'Role diperbarui.');
    }
}
