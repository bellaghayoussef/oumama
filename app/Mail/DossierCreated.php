<?php

namespace App\Mail;

use App\Models\Dossier;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DossierCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $dossier;

    public function __construct(Dossier $dossier)
    {
        $this->dossier = $dossier;
    }

    public function build()
    {
        return $this->markdown('emails.dossier-created')
                    ->subject('Nouveau dossier créé - ' . $this->dossier->id);
    }
}
