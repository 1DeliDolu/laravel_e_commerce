<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            // Benutzer nicht eingeloggt – zurück zur Loginseite oder Fehler anzeigen
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->user_type === 'user') {
            return view('user.user_dashboard');
        }

        if ($user->user_type === 'admin') {
            return view('admin.admin_dashboard');
        }

        // Optional: Fallback für andere Rollen oder fehlerhafte user_type
        abort(403, 'Unberechtigter Zugriff.');
    }
}
