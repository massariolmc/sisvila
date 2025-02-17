<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserNotification;
use App\User;
use App\CadAluno;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller
{
    public function sendEmail(Request $request, $id)
    {

         $usuario = User::findOrFail($id);

        // Validação inicial para garantir que a mensagem está presente
        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $message = $request->input('message');
        $email = $usuario->email;

        // Verificação adicional para validar o email
        if (!$this->isValidEmail($email)) {
            return redirect()->back()->withErrors(['email' => 'O endereço de e-mail não é válido.'])->withInput();
        }

        Mail::to($email)->send(new UserNotification($message));

        return back()->with('success', 'Email enviado com sucesso!');
    }

    public function sendEmailResp(Request $request, $id)
    {

         $usuario = CadAluno::findOrFail($id);

        // Validação inicial para garantir que a mensagem está presente
        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $message = $request->input('message');
        $email = $usuario->email_resp;

        // Verificação adicional para validar o email
        if (!$this->isValidEmail($email)) {
            return redirect()->back()->withErrors(['email' => 'O endereço de e-mail não é válido.'])->withInput();
        }

        Mail::to($email)->send(new UserNotification($message));

        return back()->with('success', 'Email enviado com sucesso!');
    }

    private function isValidEmail($email)
    {
        // Validação de formato de e-mail
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Verificação de DNS do domínio
        $domain = substr(strrchr($email, "@"), 1);
        return checkdnsrr($domain, 'MX');
    }
}
