<?php

namespace App\Mail;

use App\Tema;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompromisoActualizado extends Mailable
{
    use Queueable, SerializesModels;

    public $tema;
    public $estado;

    public function __construct(Tema $tema, $estado)
    {
        $this->tema = $tema;
        $this->estado = $estado;
    }

    public function build()
    {
        return $this->view('mail.compromiso_actualizado');
    }
}

?>