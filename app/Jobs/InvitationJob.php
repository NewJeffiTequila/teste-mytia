<?php

namespace App\Jobs;

use App\Mail\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class InvitationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $token;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $details = [
            'name' => 'Novo Usuário',
            'message' => 'Você está convidado para se cadastrar em nossa plataforma! ' . url("/register?token={$this->token}"),
            'date' => now()->format('d \d\e F \d\e Y'),
        ];
        Mail::to($this->email)->send(new Invite($details));
    }
}
