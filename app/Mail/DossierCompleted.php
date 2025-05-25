<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Services\FormPdfService;

class DossierCompleted extends Mailable
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
        $pdfContent = $this->pdfService->generateDossierPdf(
            $this->data['dossier'],
            $this->data['form']
        );

        $filename = sprintf(
            'dossier_%s_%s.pdf',
            $this->data['dossier']->id,
            now()->format('Y-m-d')
        );

        return $this->markdown('emails.dossier-completed')
                    ->subject('Dossier Terminé - ' . $this->data['dossier']->procedure->name)
                    ->with([
                        'dossier' => $this->data['dossier'],
                        'form' => $this->data['form'],
                        'agency' => $this->data['agency'],
                        'user' => $this->data['user']
                    ])
                    ->attachData($pdfContent, $filename, [
                        'mime' => 'application/pdf',
                    ]);
    }
}
