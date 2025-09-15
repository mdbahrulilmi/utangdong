<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use SweetAlert2\Laravel\Swal;

class isVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $creditScore = auth()->user()->borrower->credit_score ?? 0;
        $gradeSetting = \App\Models\Settings::where('min_score', '<=', $creditScore)
                        ->where('max_score', '>=', $creditScore)
                        ->first();
        $verification = auth()->user()->status;
        if (!$gradeSetting || $verification !== "verified") {
             Swal::fire([
            'title' => 'Verifikasi dulu masbro!',
            'text' => 'Harus verifikasi dulu baru bisa ajuin peminjaman!',
            'icon' => 'error',
            'confirmButtonText' => 'Oke saya verifikasi sekarang!'
        ]);
            return redirect()->route('dashboard')->with('status','belum di verifikasi');
        }else{
            return $next($request);
        }
    }
}
