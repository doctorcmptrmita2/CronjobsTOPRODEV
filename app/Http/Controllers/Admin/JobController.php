<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with('user')->latest('updated_at');

        if ($request->get('status') === 'active') {
            $query->where('is_active', true);
        } elseif ($request->get('status') === 'paused') {
            $query->where('is_active', false);
        }

        if ($request->boolean('failing')) {
            $query->where('consecutive_failures', '>', 0);
        }

        $jobs = $query->paginate(20)->appends($request->only(['status', 'failing']));

        return view('admin.jobs.index', compact('jobs'));
    }
}
