<?php

namespace App\Http\Controllers;

use App\Http\Controllers\GmailController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApiController extends Controller
{
    private $gmailController;

    public function __construct(GmailController $gmailController)
    {
        $this->gmailController = $gmailController;
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
        ]);

        $user = User::create([
            'email' => $request->input('email'),
        ]);

        // Send welcome email asynchronously using a queue
        Mail::to($user->email)->queue(new \App\Mail\WelcomeMail());

        // Send email using Gmail API
        $subject = 'Welcome to Your App';
        $body = 'Thank you for registering with Your App! We\'re excited to have you on board.';
        $this->gmailController->sendEmail($user->email, $subject, $body);

        return response()->json(['message' => 'Registration successful'], 201);
    }
}
