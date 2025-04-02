<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\InvitationJob;
use App\Mail\Invite;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;


class InvitationController extends Controller
{
    public function sendInvite(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json(['message' => 'Usuário já existe!'], 409);
        }

        $token = Str::random(32);
        $invitation = Invitation::where('email', $request->email)->first();
        if ($invitation) {
            $invitation->update([
                'token' => $token,
                'expires_at' => Carbon::now()->addHours(48)
            ]);
        } else {
            $invitation = Invitation::create([
                'email' => $request->email,
                'token' => $token,
                'role' => $request->role,
                'expires_at' => Carbon::now()->addHours(48)
            ]);
        }
        InvitationJob::dispatch($request->email, $token);

        $details = [
            'name' => 'Novo Usuário',
            'message' => 'Você está convidado para se cadastrar em nossa plataforma!' . url("/register?token={$token}"),
            'date' => now()->format('d \d\e F \d\e Y')
        ];

        Mail::to($request->email)->send(new Invite($details));

        return response()->json(['message' => 'Convite enviado com sucesso!', 'token' => $token]);
    }
}
