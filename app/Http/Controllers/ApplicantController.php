<?php

namespace App\Http\Controllers;

use App\Mail\AcceptApplicant;
use App\Mail\RejectApplicant;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use App\Models\Applicant;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ApplicantController extends Controller
{
    public function indexPending(Request $request)
    {
        $applicants = Application::where('status', 'PENDING')->when(
            $request->search,
            function ($query) use ($request) {
                $query->whereHas('applicant', function ($query) use ($request) {
                    $query->where('firstname', 'like', '%' . $request->search . '%')
                        ->orWhere('middlename', 'like', '%' . $request->search . '%')
                        ->orWhere('lastname', 'like', '%' . $request->search . '%');
                });
            }
        )->with('applicant')->paginate(10);
        return Inertia::render('Applicant/Index', [
            'applicants' => $applicants,
        ]);
    }

    public function indexAccepted(Request $request)
    {
        $applicants = Application::where('status', 'ACCEPTED')->when(
            $request->search,
            function ($query) use ($request) {
                $query->whereHas('applicant', function ($query) use ($request) {
                    $query->where('firstname', 'like', '%' . $request->search . '%')
                        ->orWhere('middlename', 'like', '%' . $request->search . '%')
                        ->orWhere('lastname', 'like', '%' . $request->search . '%');
                });
            }
        )->with('applicant')->paginate(10);
        return Inertia::render('Applicant/Index', [
            'applicants' => $applicants,
        ]);
    }

    public function indexRejected(Request $request)
    {
        $applicants = Application::where('status', 'REJECTED')->when(
            $request->search,
            function ($query) use ($request) {
                $query->whereHas('applicant', function ($query) use ($request) {
                    $query->where('firstname', 'like', '%' . $request->search . '%')
                        ->orWhere('middlename', 'like', '%' . $request->search . '%')
                        ->orWhere('lastname', 'like', '%' . $request->search . '%');
                });
            }
        )->with('applicant')->paginate(10);
        return Inertia::render('Applicant/Index', [
            'applicants' => $applicants,
        ]);
    }

    public function view($id) {
        $applicant = Applicant::with(['parents', 'application'])->find($id);
        return Inertia::render('Applicant/View', [
            'applicant' => $applicant,
        ]);
    }

    public function accept($id, Request $request) {
        $applicant = Applicant::find($id);
        $application = Application::where('applicant_id',$id)->first();
        $application->update([
            'status' => 'ACCEPTED',
            'interview_date' => $request->interview_date,
            'interview_time' => $request->interview_time,
        ]);

        Mail::to($applicant->email)->send(mailable: new AcceptApplicant($applicant));
        return Redirect::back();
    }

    public function reject($id) {
        $applicant = Applicant::find($id);
        $application = Application::where('applicant_id', $id)->first();
        $application->update([
            'status' => 'REJECTED',
        ]);

        Mail::to($applicant->email)->send(mailable: new RejectApplicant($applicant));
        return Redirect::back();
    }
}
