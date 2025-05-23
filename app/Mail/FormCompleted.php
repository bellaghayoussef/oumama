<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormCompleted extends Mailable
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
        return $this->markdown('emails.form-completed')
                    ->subject('Formulaire Complété - ' . $this->data['dossier']->procedure->name)
                    ->with([
                        'dossier' => $this->data['dossier'],
                        'form' => $this->data['form'],
                        'nextTask' => $this->data['nextTask'],
                        'agency' => $this->data['agency'],
                        'user' => $this->data['user']
                    ]);
    }
}
