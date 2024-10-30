<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicantController extends Controller
{
    public function index()
    {
        return Inertia::render('Applicant/Index');
    }
}
