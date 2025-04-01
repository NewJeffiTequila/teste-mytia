<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\Invite;
use App\Models\Invitation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;


class InvitationController extends Controller
{
    public function sendInvite(Request $request)
    {
        // // Valida os dados da requisição
        // $request->validate([
        //     'email' => 'required|email|unique:invitations,email', // Garante que o email ainda não recebeu um convite
        //     'role' => 'required|in:admin,moderator,user' // Define a permissão do novo usuário
        // ]);

        // // Gerar token único
        $token = Str::random(32);

        // // Salvar o convite no banco de dados
        Invitation::create([
            'email' => $request->email,
            'token' => $token,
            'role' => $request->role,
            'expires_at' => Carbon::now()->addDays(7) // Expira em 7 dias
        ]);

        // // Criar os detalhes do e-mail
        $details = [
            'name' => 'Novo Usuário',
            'message' => 'Você está convidado para se cadastrar em nossa plataforma!' . url("/register?token={$token}"),
            // 'invite_url' => url("/register?token={$token}"), // Link de cadastro com o token
            'date' => now()->format('d \d\e F \d\e Y')
        ];

        Mail::to($request->email)->send(new Invite($details));

        return response()->json(['message' => 'Convite enviado com sucesso!', 'token' => $token]);

        // $details = [
        //     'name' => 'João Silva',
        //     'message' => 'Você está convidado para nossa conferência anual! '. $token ,
        //     'date' => '10 de Abril de 2025'
        // ];

        // Mail::to('jeffitequila@gmail.com')->send(new Invite($details));

        // return response()->json(['message' => 'E-mail enviado com sucesso!']);
    }
}
