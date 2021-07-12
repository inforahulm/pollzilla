<?php

namespace App\Http\Middleware;

use Closure;
use App\Classes\CustomEncrypt;

class DecryptRequest {

    private $ecnrypter;

    public function __construct() {
        $this->ecnrypter = new CustomEncrypt();
    }

    public function handle($request, Closure $next) {
        if ($request->env != "local") {
            $content = $request->getContent();
            if (!$request->isMethod('get') && $content !== "") {
                $request->replace([]);
                $post = $this->ecnrypter->decrypt($content);
                if ($post) {
                    $request->merge($post);
                }
            }
        }

        return $next($request);
    }
}
