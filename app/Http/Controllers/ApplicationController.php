<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function create()
    {
        return Inertia::render('Application/ApplicantForm');
    }

    public function validatePersonalInfo(Request $request) 
    {
        $request->validate([
            'firstname' => 'required',
            'middlename' => 'required',
            'lastname' => 'required',
            'age' => 'required',
            'sex' => 'required',
            'birthdate' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'status' => 'required',
            'citizenship' => 'required',
            'barangay' => 'required',
            'municipality' => 'required',
            'province' => 'required',
            'country' => 'required',
            'email' => 'required|email',
        ]);

        return redirect()->route('application.create');
    }

    public function validateParentsBackground(Request $request) 
    {
        $request->validate([
            'mother_firstname' => 'required',
            'mother_middlename' => 'required',
            'mother_lastname' => 'required',
            'mother_occupation' => 'required',
            'father_firstname' => 'required',
            'father_middlename' => 'required',
            'father_lastname' => 'required',
            'father_occupation' => 'required',
        ]);

        return redirect()->route('application.create');
    }
}
