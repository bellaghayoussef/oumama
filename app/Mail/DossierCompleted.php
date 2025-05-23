<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DossierCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->markdown('emails.dossier-completed')
                    ->subject('Dossier Terminé - ' . $this->data['dossier']->procedure->name)
                    ->with([
                        'dossier' => $this->data['dossier'],
                        'form' => $this->data['form'],
                        'agency' => $this->data['agency'],
                        'user' => $this->data['user']
                    ]);
    }
}
