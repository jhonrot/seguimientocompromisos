<?php

namespace App\Mail;

use App\Tema;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompromisoAlerta extends Mailable
{
    use Queueable, SerializesModels;

    public $tema;

    public function __construct(Tema $tema)
    {
        $this->tema = $tema;
    }

    public function build()
    {
        return $this->view('mail.compromiso_alerta')->subject("Compromiso Alerta");
    }
}

?>