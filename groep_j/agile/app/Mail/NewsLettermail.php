<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\UploadedFile;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsLettermail extends Mailable
{
    use Queueable, SerializesModels;



    public array $data;
    public UploadedFile  $pdf;
    public function __construct(array $data, UploadedFile $pdf)
    {
        $this->data = $data;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject($this->data['subject'] ?? 'Concat nieuwsbrief')
            ->markdown('emails.newsletter')
            ->with('data', $this->data)
            ->attach($this->pdf->getRealPath(), [
                'as' => $this->pdf->getClientOriginalName(),
                'mime' => 'application/pdf',
            ]);
    }


}
