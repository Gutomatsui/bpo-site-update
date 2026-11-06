<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ambientes que não são produção (local, teste, homologação):
 *  - nunca são indexados (cabeçalho X-Robots-Tag em todas as respostas);
 *  - podem exigir usuário/senha (HTTP Basic) via STAGING_AUTH_USER/PASSWORD.
 */
class ProtectNonProduction
{
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->isProduction()) {
            return $next($request);
        }

        $user = (string) config('site.staging_auth.user');
        $password = (string) config('site.staging_auth.password');

        if ($user !== '' && $password !== '') {
            $validUser = hash_equals($user, (string) $request->getUser());
            $validPassword = hash_equals($password, (string) $request->getPassword());

            if (! $validUser || ! $validPassword) {
                return response('Acesso restrito.', 401, [
                    'WWW-Authenticate' => 'Basic realm="Solution BPO - homologacao", charset="UTF-8"',
                    'X-Robots-Tag' => 'noindex, nofollow',
                ]);
            }
        }

        $response = $next($request);
        $response->headers->set('X-Robots-Tag', 'noindex, nofollow');

        return $response;
    }
}
