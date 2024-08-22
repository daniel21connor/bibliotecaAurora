<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function verContacto()
    {
        return view('contacto');
    }

    public function enviar(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mensaje' => 'required|string',
        ]);

        // Aquí podrías manejar el envío de correo electrónico, guardar en base de datos, etc.
        // Por ejemplo, podrías usar el sistema de correo de Laravel para enviar un email

        // Mail::to('tu-email@ejemplo.com')->send(new ContactoMail($request->all()));

        return redirect('/contacto')->with('success', 'Mensaje enviado correctamente.');
    }
}
