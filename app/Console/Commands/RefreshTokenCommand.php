<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RefreshTokenCommand extends Command
{
    protected $signature = 'multivende:refresh-token';
    protected $description = 'Renueva el token de acceso usando el refresh_token guardado en la base de datos';

    public function handle()
    {
        $tokenRecord = DB::connection('mysql2')->table('multivende_tokens')->first();

        if (!$tokenRecord) {
            $this->error('No se encontró ningún token en la base de datos.');
            return;
        }
        $client_id = $tokenRecord->client_id;
        $client_secret = $tokenRecord->client_secret;
        $refreshToken = $tokenRecord->refresh_token;
        $response = Http::withHeaders([
            'cache-control' => 'no-cache',
            'Content-Type' => 'application/json',
            'Cookie' => 'route=1729786309.21.314.465187|0bbbab1f8d05854c3f59702dc1a8e51e',
        ])->post('https://app.multivende.com/oauth/access-token', [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ]);

        if ($response->successful()) {
            $responseData = $response->json();

            DB::connection('mysql2')->table('multivende_tokens')
                ->where('client_id', $client_id)
                ->update([
                    'token' => $responseData['token'], 
                    'refresh_token' => $responseData['refreshToken'], 
                    'expires_at' => Carbon::parse($responseData['expiresAt']), 
                    'updated_at' => now(), 
                ]);

            $this->info('El token de acceso ha sido renovado exitosamente.');
        } else {
            $this->error('Error al renovar el token de acceso: ' . $response->body());
        }
    }
}
