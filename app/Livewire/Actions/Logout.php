<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke(): void
    {
        Auth()->User()->User_History()->create([
            'Move' => 'Logout',
            'Notes_id' => 0
        ]);

        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();
    }
}
