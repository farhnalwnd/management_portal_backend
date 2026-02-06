<?php

namespace App\Mail;

use App\Models\ApprovalMgt;
use App\Models\ContentMgt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendApprovalMail extends Mailable
{
    use Queueable, SerializesModels;
    public $contentMgt;
    public $approvalMgt;
    public $approveLink;
    public $rejectLink;

    /**
     * Create a new message instance.
     */
    public function __construct(ContentMgt $contentMgt, ApprovalMgt $approvalMgt, $approveLink, $rejectLink)
    {
        $this->contentMgt = $contentMgt;
        $this->approvalMgt = $approvalMgt;
        $this->approveLink = $approveLink;
        $this->rejectLink = $rejectLink;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'System Portal Management: Permohonan Persetujuan Konten ' . $this->contentMgt->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.send-approval-mail',
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
