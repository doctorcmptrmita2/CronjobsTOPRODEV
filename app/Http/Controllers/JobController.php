<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Jobs\RunJob;
use App\Models\Job;
use App\Services\JobSchedulerService;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $jobs = $request->user()->jobs()->latest()->paginate(10);

        return view('jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store(StoreJobRequest $request, JobSchedulerService $scheduler)
    {
        $job = new Job($this->prepareJobData($request));
        $job->user_id = $request->user()->id;
        $job->timezone = $job->timezone ?: $request->user()->timezone;
        $job->next_run_at = $scheduler->calculateNextRun($job);
        $job->save();

        return redirect()->route('jobs.show', $job)->with('status', 'Job created successfully');
    }

    public function show(Job $job)
    {
        $this->ensureOwnership($job);

        $runs = $job->runs()->latest('ran_at')->paginate(20);

        return view('jobs.show', compact('job', 'runs'));
    }

    public function edit(Job $job)
    {
        $this->ensureOwnership($job);

        return view('jobs.edit', compact('job'));
    }

    public function update(UpdateJobRequest $request, JobSchedulerService $scheduler, Job $job)
    {
        $this->ensureOwnership($job);

        $job->fill($this->prepareJobData($request));
        $job->timezone = $job->timezone ?: $request->user()->timezone;
        $job->next_run_at = $scheduler->calculateNextRun($job);
        $job->save();

        return redirect()->route('jobs.show', $job)->with('status', 'Job updated');
    }

    public function destroy(Job $job)
    {
        $this->ensureOwnership($job);
        $job->delete();

        return redirect()->route('jobs.index')->with('status', 'Job deleted');
    }

    public function toggle(Job $job, JobSchedulerService $scheduler)
    {
        $this->ensureOwnership($job);
        $job->is_active = ! $job->is_active;

        if ($job->is_active && ! $job->next_run_at) {
            $job->next_run_at = $scheduler->calculateNextRun($job);
        }

        $job->save();

        return back()->with('status', 'Job status updated');
    }

    public function runNow(Job $job)
    {
        $this->ensureOwnership($job);

        $job->update(['locked_at' => now()]);
        RunJob::dispatch($job->id);

        return back()->with('status', 'Job queued to run');
    }

    protected function ensureOwnership(Job $job): void
    {
        if ($job->user_id !== auth()->id()) {
            abort(403);
        }
    }

    protected function prepareJobData(Request $request): array
    {
        $headers = [];
        $rawHeaders = $request->input('headers', []);

        foreach ($rawHeaders as $header) {
            $key = $header['key'] ?? null;
            $value = $header['value'] ?? null;

            if ($key && $value && trim($key) !== '') {
                $headers[trim($key)] = trim($value);
            }
        }

        return [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'url' => $request->input('url'),
            'http_method' => $request->input('http_method'),
            'headers_json' => !empty($headers) ? json_encode($headers) : null,
            'body' => $request->input('body'),
            'timeout_seconds' => $request->integer('timeout_seconds'),
            'expected_status_from' => $request->integer('expected_status_from'),
            'expected_status_to' => $request->integer('expected_status_to'),
            'schedule_type' => $request->input('schedule_type'),
            'interval_minutes' => $request->input('interval_minutes'),
            'daily_time' => $request->input('daily_time'),
            'weekly_day_of_week' => $request->input('weekly_day_of_week'),
            'cron_expression' => $request->input('cron_expression'),
            'timezone' => $request->input('timezone'),
            'is_active' => $request->boolean('is_active'),
            'max_retries' => $request->integer('max_retries'),
            'failure_alert_threshold' => $request->integer('failure_alert_threshold'),
            'alert_email_enabled' => $request->boolean('alert_email_enabled', true),
        ];
    }
}
