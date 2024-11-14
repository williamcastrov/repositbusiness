<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnvioTokenMRP extends Mailable
{
    use Queueable, SerializesModels;

    public $datos;

    public function __construct($datos)
    {
        $this->datos = $datos;          
    }
    public function build()
    {
        return $this->from($this->datos->from, $this->datos->name_from)
                    ->subject($this->datos->asunto)
                    ->view('mail.' . $this->datos->plantilla)
                    ->with([
                        'contenido_html' => $this->datos->contenido_html,
                        'asunto' => $this->datos->asunto
                    ]);
    }
}
