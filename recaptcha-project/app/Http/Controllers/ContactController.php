<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact'); // Ensure this matches your Blade file name
    }

    public function submitForm(Request $request)
    {
        // Debug: Check if reCAPTCHA response is received
        if (!$request->has('g-recaptcha-response')) {
            return back()->withErrors(['g-recaptcha-response' => 'reCAPTCHA response missing.']);
        }
    
        // Validate input fields
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string'
        ]);
    
        // reCAPTCHA Validation
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip()
        ]);
    
        $responseData = $response->json(); // Debugging output
        \Log::info('reCAPTCHA Response:', $responseData); // Log response
    
        if (!$responseData['success']) {
            return back()->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed.']);
        }
    
        return redirect()->back()->with('success', 'Message sent successfully!');
    }
    
    

}
