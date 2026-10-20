<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuickLoginController extends Controller
{
    /**
     * Development users available for quick login, by role.
     *
     * @var array<string, string>
     */
    private const USERS = [
        'admin' => 'admin@florahub.test',
        'user' => 'user@florahub.test',
    ];

    /**
     * Log in as a predefined development user (local environment only).
     */
    public function __invoke(Request $request, string $role): RedirectResponse
    {
        abort_unless(app()->isLocal(), 404);

        $user = User::where('email', self::USERS[$role])->firstOrFail();

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route($user->dashboardRoute());
    }
}
