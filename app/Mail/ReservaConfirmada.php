<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ReservaConfirmada extends Mailable
{
    public $reserva;

    public function __construct($reserva)
    {
        $this->reserva = $reserva;
    }

    public function build()
    {
        return $this->subject('Confirmação de Reserva')
                    ->view('emails.reservaConfirmada')
                    ->with([
                        'horario' => $this->reserva->horario_selecionado,
                        'unidade' => $this->reserva->unidade->nome_fantasia,
                        'mesas' => $this->reserva->num_mesas,
                    ]);
    }
}
