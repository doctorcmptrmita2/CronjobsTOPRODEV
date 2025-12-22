<?php

namespace App\Services;

use App\Models\Job;
use Illuminate\Support\Facades\Http;

class JobRunnerService
{
    public function run(Job $job): array
    {
        $start = microtime(true);
        $statusCode = null;
        $body = null;
        $errorMessage = null;

        try {
            $response = Http::retry($job->max_retries, 1000)
                ->timeout($job->timeout_seconds)
                ->withHeaders($job->preparedHeaders())
                ->send($job->http_method, $job->url, [
                    'body' => $job->body,
                ]);

            $statusCode = $response->status();
            $body = $response->body();
            $errorMessage = $response->successful() ? null : $response->reason();
        } catch (\Throwable $exception) {
            $errorMessage = $exception->getMessage();
        }

        $durationMs = (int) round((microtime(true) - $start) * 1000);

        $success = $statusCode !== null
            && $statusCode >= $job->expected_status_from
            && $statusCode <= $job->expected_status_to;

        return [
            'status_code' => $statusCode,
            'duration_ms' => $durationMs,
            'success' => $success,
            'error_message' => $success ? null : $errorMessage,
            'response_snippet' => $body ? mb_substr($body, 0, 500) : null,
        ];
    }
}









