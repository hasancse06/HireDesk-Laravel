<?php

namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public JobApplication $application
    ) {
        $this->application->loadMissing(['jobPost']);
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Application Status Updated')
            ->line('Your application status has been updated.')
            ->line('Job: ' . $this->application->jobPost->title)
            ->line('Company: ' . $this->application->jobPost->company_name)
            ->line('Status: ' . ucfirst($this->application->status));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'job_post_id' => $this->application->job_post_id,
            'job_title' => $this->application->jobPost->title,
            'company_name' => $this->application->jobPost->company_name,
            'status' => $this->application->status,
            'message' => $this->message(),
            'url' => route('applicant.applications.show', $this->application),
        ];
    }

    private function message(): string
    {
        return match ($this->application->status) {
            'selected' => 'Congratulations! You have been selected for this job.',
            'rejected' => 'Your application was not selected for this job.',
            'shortlisted' => 'Your application has been shortlisted.',
            default => 'Your application status has been updated.',
        };
    }
}