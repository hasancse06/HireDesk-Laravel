<?php

namespace App\Mail;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusUpdatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public JobApplication $application
    ) {
        $this->application->loadMissing(['jobPost', 'applicant']);
    }

    public function envelope(): Envelope
    {
        $status = ucfirst($this->application->status);

        return new Envelope(
            subject: "{$status}: Your application for {$this->application->jobPost->title}"
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.applications.status-updated',
            with: [
                'application' => $this->application,
                'job' => $this->application->jobPost,
                'applicant' => $this->application->applicant,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}