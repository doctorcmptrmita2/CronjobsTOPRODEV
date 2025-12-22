<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobRun;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function status()
    {
        // Get system stats for the last 24 hours
        $stats = [
            'total_jobs' => Job::count(),
            'active_jobs' => Job::where('is_active', true)->count(),
            'runs_today' => JobRun::whereDate('ran_at', today())->count(),
            'success_rate' => $this->calculateSuccessRate(),
            'avg_response_time' => $this->calculateAvgResponseTime(),
        ];

        // Get recent incidents (jobs with consecutive failures)
        $incidents = Job::where('consecutive_failures', '>=', 3)
            ->with('user')
            ->latest('updated_at')
            ->limit(5)
            ->get();

        return view('pages.status', compact('stats', 'incidents'));
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'type' => 'required|in:general,support,abuse,other',
        ]);

        // In production, send email or store in database
        // For now, just redirect with success message

        return redirect()->route('contact')
            ->with('success', 'Thank you for your message! We\'ll get back to you within 24 hours.');
    }

    public function faq()
    {
        $faqs = [
            [
                'category' => 'Getting Started',
                'questions' => [
                    [
                        'q' => 'What is Cronjobs.to?',
                        'a' => 'Cronjobs.to is a cloud-based cron job scheduling service that allows you to schedule HTTP requests to any URL at specified intervals. We handle the scheduling, execution, monitoring, and alerting so you can focus on building your application.'
                    ],
                    [
                        'q' => 'How do I create my first cron job?',
                        'a' => 'Simply enter your URL on our homepage, select your schedule (or use our cron expression builder), and click "Test This Job". You can test it for free before signing up. Once you register, your job will be saved and start running automatically.'
                    ],
                    [
                        'q' => 'Do I need to install anything?',
                        'a' => 'No! Cronjobs.to is a fully cloud-based service. You don\'t need to install any software, manage servers, or configure crontabs. Just sign up and start scheduling.'
                    ],
                ],
            ],
            [
                'category' => 'Scheduling',
                'questions' => [
                    [
                        'q' => 'What is a cron expression?',
                        'a' => 'A cron expression is a string of five fields that define a schedule: minute, hour, day of month, month, and day of week. For example, "*/15 * * * *" means "every 15 minutes". We provide preset buttons and a visual builder to make it easy.'
                    ],
                    [
                        'q' => 'What\'s the minimum interval I can set?',
                        'a' => 'Free plans can schedule jobs with a minimum interval of 15 minutes. Pro plans can schedule jobs as frequently as every 1 minute.'
                    ],
                    [
                        'q' => 'Can I schedule jobs in my local timezone?',
                        'a' => 'Yes! When creating a job, you can select your timezone. All schedules will be calculated based on your selected timezone, but internally we store everything in UTC for consistency.'
                    ],
                ],
            ],
            [
                'category' => 'Monitoring & Alerts',
                'questions' => [
                    [
                        'q' => 'How will I know if my job fails?',
                        'a' => 'We monitor every execution and track success/failure based on HTTP status codes. If your job fails consecutively (default: 3 times), we\'ll send you an email alert immediately.'
                    ],
                    [
                        'q' => 'What counts as a successful run?',
                        'a' => 'By default, any HTTP status code between 200-299 is considered successful. You can customize this range for each job if your endpoint returns different status codes.'
                    ],
                    [
                        'q' => 'Can I see the response from my endpoint?',
                        'a' => 'Yes! We store the first 500 characters of each response, along with the status code, response time, and any error messages. You can view these in the job run history.'
                    ],
                ],
            ],
            [
                'category' => 'Security & Reliability',
                'questions' => [
                    [
                        'q' => 'Is my data secure?',
                        'a' => 'Yes. All data is encrypted in transit (HTTPS) and at rest. We never share your data with third parties. You can also use custom headers to add authentication tokens to your requests.'
                    ],
                    [
                        'q' => 'What happens if your service goes down?',
                        'a' => 'We run on redundant infrastructure with 99.9% uptime SLA for Pro plans. In the rare event of downtime, missed jobs will be queued and executed as soon as service is restored.'
                    ],
                    [
                        'q' => 'Can I send custom headers with my requests?',
                        'a' => 'Yes! You can add any custom headers including Authorization tokens, API keys, Content-Type, and more. This is useful for authenticating your cron endpoints.'
                    ],
                ],
            ],
            [
                'category' => 'Billing & Plans',
                'questions' => [
                    [
                        'q' => 'Is there a free plan?',
                        'a' => 'Yes! Our free plan includes up to 5 jobs with a minimum interval of 15 minutes and 7 days of log retention. No credit card required.'
                    ],
                    [
                        'q' => 'What\'s included in the Pro plan?',
                        'a' => 'Pro plans include unlimited jobs, 1-minute minimum intervals, 30 days of log retention, priority support, and advanced features like webhooks and API access.'
                    ],
                    [
                        'q' => 'Can I cancel anytime?',
                        'a' => 'Yes, you can cancel your subscription at any time. Your jobs will continue to run until the end of your billing period, then downgrade to the free plan limits.'
                    ],
                ],
            ],
        ];

        return view('pages.faq', compact('faqs'));
    }

    protected function calculateSuccessRate(): float
    {
        $total = JobRun::where('ran_at', '>=', now()->subDay())->count();
        if ($total === 0) return 100.0;

        $successful = JobRun::where('ran_at', '>=', now()->subDay())
            ->where('success', true)
            ->count();

        return round(($successful / $total) * 100, 2);
    }

    protected function calculateAvgResponseTime(): int
    {
        return (int) JobRun::where('ran_at', '>=', now()->subDay())
            ->avg('duration_ms') ?? 0;
    }
}









