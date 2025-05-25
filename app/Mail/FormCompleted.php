<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Services\FormPdfService;

class FormCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    protected $pdfService;

    /**
     * Create a new message instance.
     */
    public function __construct($data, FormPdfService $pdfService)
    {
        $this->data = $data;
        $this->pdfService = $pdfService;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $pdfContent = $this->pdfService->generateFormPdf(
            $this->data['dossier'],
            $this->data['form'],
            $this->data['nextTask'] ?? null
        );

        $filename = sprintf(
            'formulaire_%s_%s.pdf',
            $this->data['dossier']->id,
            now()->format('Y-m-d')
        );

        return $this->markdown('emails.form-completed')
                    ->subject('Formulaire Complété - ' . $this->data['dossier']->procedure->name)
                    ->with([
                        'dossier' => $this->data['dossier'],
                        'form' => $this->data['form'],
                        'nextTask' => $this->data['nextTask'],
                        'agency' => $this->data['agency'],
                        'user' => $this->data['user']
                    ])
                    ->attachData($pdfContent, $filename, [
                        'mime' => 'application/pdf',
                    ]);
    }
}
