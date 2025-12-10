<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobRun;

class JobRunController extends Controller
{
    public function show(Job $job, JobRun $run)
    {
        if ($job->user_id !== auth()->id()) {
            abort(403);
        }

        return view('jobs.runs.show', compact('job', 'run'));
    }
}
