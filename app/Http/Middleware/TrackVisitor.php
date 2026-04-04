<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Visitor;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('visitor_tracked')) {

            $ip = $request->ip();

            $country = 'Unknown';
            $city = null;

            try {
                $response = Http::get("http://ip-api.com/json/{$ip}");

                if ($response->successful()) {
                    $data = $response->json();

                    $country = $data['country'] ?? 'Unknown';
                    $city = $data['city'] ?? null;
                }
            } catch (\Exception $e) {
            }
            $exiest = Visitor::where('ip', $ip)->first();
            if ($exiest) {
                session(['visitor_tracked' => true]);
                return $next($request);
            }

            Visitor::create([
                'ip' => $ip,
                'country' => $country,
                'city' => $city,
                'user_agent' => $request->userAgent(),
            ]);

            session(['visitor_tracked' => true]);
        }

        return $next($request);
    }
}