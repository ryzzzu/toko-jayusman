<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

trait ResolvesUserBranch
{
    protected function ensureBranchAssigned(): int|RedirectResponse
    {
        $user = Auth::user();

        if ($user->role === 'owner') {
            return 0;
        }

        if (!$user->branch_id) {
            return redirect()->route('dashboard')
                ->with('error', 'Akun Anda belum terhubung ke cabang. Hubungi Pak Jayusman.');
        }

        return (int) $user->branch_id;
    }
}
