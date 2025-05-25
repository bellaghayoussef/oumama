<?php

namespace App\Services;

use Barryvdh\DomPDF\PDF;
use App\Models\Dossier;
use App\Models\Formuler;
use App\Models\Task;

class FormPdfService
{
    protected $pdf;

    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;
        $this->pdf->setPaper('a4');
        $this->pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'isPhpEnabled' => true,
            'isFontSubsettingEnabled' => true,
            'defaultFont' => 'sans-serif'
        ]);
    }

    public function generateFormPdf(Dossier $dossier, Formuler $form, ?Task $nextTask = null)
    {
        $data = [
            'dossier' => $dossier->load(['procedure', 'user', 'agency']),
            'form' => $form->load('variables'),
            'nextTask' => $nextTask,
            'date' => now()->format('d/m/Y'),
            'signature' => $dossier->user->signature ?? null,
            'agency_signature' => $dossier->agency->signature ?? null,
        ];

        return $this->pdf->loadView('pdfs.form-response', $data)->output();
    }

    public function generateDossierPdf(Dossier $dossier, Formuler $form)
    {
        $data = [
            'dossier' => $dossier->load(['procedure', 'user', 'agency']),
            'form' => $form->load('variables'),
            'date' => now()->format('d/m/Y'),
            'signature' => $dossier->user->signature ?? null,
            'agency_signature' => $dossier->agency->signature ?? null,
        ];

        return $this->pdf->loadView('pdfs.dossier-completion', $data)->output();
    }
}
