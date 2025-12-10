<?php

namespace App\Http\Requests;

use App\Models\Plan;
use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'url' => ['required', 'url'],
            'http_method' => ['required', 'in:GET,POST,PUT,DELETE,PATCH'],
            'headers' => ['nullable', 'array'],
            'headers.key' => ['nullable', 'array'],
            'headers.value' => ['nullable', 'array'],
            'body' => ['nullable', 'string'],
            'timeout_seconds' => ['required', 'integer', 'min:1', 'max:120'],
            'expected_status_from' => ['required', 'integer', 'min:100', 'max:599'],
            'expected_status_to' => ['required', 'integer', 'min:100', 'max:599', 'gte:expected_status_from'],
            'schedule_type' => ['required', 'in:interval,daily,weekly,cron'],
            'interval_minutes' => ['nullable', 'integer', 'min:1', 'required_if:schedule_type,interval'],
            'daily_time' => ['nullable', 'required_if:schedule_type,daily,weekly', 'date_format:H:i'],
            'weekly_day_of_week' => ['nullable', 'required_if:schedule_type,weekly', 'integer', 'between:0,6'],
            'cron_expression' => ['nullable', 'required_if:schedule_type,cron', 'string'],
            'timezone' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
            'max_retries' => ['required', 'integer', 'min:1', 'max:3'],
            'failure_alert_threshold' => ['required', 'integer', 'min:1', 'max:10'],
            'alert_email_enabled' => ['sometimes', 'boolean'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $user = $this->user();

            if (! $user) {
                return;
            }

            $plan = $user->plan ?? Plan::where('slug', 'free')->first();
            $minInterval = $plan?->min_interval_minutes ?? 15;

            if ($this->input('schedule_type') === 'interval' && $this->filled('interval_minutes')) {
                if ((int) $this->input('interval_minutes') < $minInterval) {
                    $validator->errors()->add('interval_minutes', __('Minimum interval is :minutes minutes for your plan.', ['minutes' => $minInterval]));
                }
            }
        });
    }
}
