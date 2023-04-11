<?php

namespace App\Mail;

use App\Tema;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TemaPrioridadAlta extends Mailable
{
    use Queueable, SerializesModels;

    public $tema;

    public function __construct(Tema $tema)
    {
        $this->tema = $tema;
    }

    public function build()
    {
        return $this->view('mail.tema_prioridad_alta');
    }
}

?>