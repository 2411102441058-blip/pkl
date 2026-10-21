<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\JobListing;

class JobStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public JobListing $job;
    public string $status;

    /**
     * Create a new message instance.
     */
    public function __construct(JobListing $job, string $status)
    {
        $this->job = $job;
        $this->status = $status;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = 'Update Status Loker: ' . $this->job->posisi;
        if ($this->status === 'approved_gratis' || $this->status === 'approved_premium') {
            $subject = '🎉 Loker Anda Telah Tayang: ' . $this->job->posisi;
        } elseif ($this->status === 'rejected') {
            $subject = 'Mohon Maaf, Loker Anda Ditolak: ' . $this->job->posisi;
        }

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.job-status',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
