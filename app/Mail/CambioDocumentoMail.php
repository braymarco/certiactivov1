<?php

namespace App\Mail;

use App\Models\DocumentUpdate;
use App\Models\SignatureRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CambioDocumentoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * @param SignatureRequest $solicitud
     * @param DocumentUpdate $documentUpdate
     */
    public function __construct(public SignatureRequest $solicitud, public DocumentUpdate $documentUpdate)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Firma Electrónica Certiactivo - Observación',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.cambiar_documento',
            with: [
                'solicitud' => $this->solicitud,
                'docUp'=>$this->documentUpdate
            ]
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
