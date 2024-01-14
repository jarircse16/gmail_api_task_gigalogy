<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming your User model is in the 'App\Models' namespace
use App\Mail\DemoMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
  public function index()
  {
      $maildata = [
          'title' => 'Welcome to my website',
          'body' => 'Registration Successful',
      ];

      // Pass $maildata to the view
      return view('welcome')->with('maildata', $maildata);
  }


    public function store(Request $request)
    {
        // Validate and store user data (you might have additional logic here)

        // Assuming you have 'email' field in your registration form
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            // Add other fields as needed
        ]);

        // Send welcome email
        $maildata = [
            'title' => 'Welcome to my website',
            'body' => 'Registration Successful',
        ];

        Mail::to($user->email)->send(new DemoMail($maildata));

        // Redirect or respond with a success message
        return redirect()->route('success')->with('message', 'Registration successful. Check your email for a welcome message.');
    }

  public function showRegistrationForm()
{
    return view('register');
}

}
