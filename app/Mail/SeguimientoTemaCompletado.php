<?php

namespace App\Mail;

use App\Seguimiento;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SeguimientoTemaCompletado extends Mailable
{
    use Queueable, SerializesModels;

    public $seguimiento;

    public function __construct(Seguimiento $seguimiento)
    {
        $this->seguimiento = $seguimiento;
    }

    public function build()
    {
        return $this->view('mail.seguimiento_tema_completada');
    }
}

?>