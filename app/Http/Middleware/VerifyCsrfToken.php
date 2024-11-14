<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'mrp/api/*',
        'cyclewear/api/*',
        'mrp/api/*/*',
        'cyclewear/api/*/*',
<<<<<<< HEAD
        'gimcloud/api/*/*',
        'gimcloud/api/*',
        'gimcloudzafiro/api/*/*',
        'gimcloudzafiro/api/*',
        'gimcloudwilcar/api/*/*',
        'gimcloudwilcar/api/*',
=======
        'constructora/api/*/*',
        'constructora/api/*',
        'servicare/api/*/*',
        'servicare/api/*',
        'bru/api/*/*',
        'bru/api/*',
        'villalaura/api/*/*',
        'villalaura/api/*',
        'salespoint/api/*/*',
        'salespoint/api/*',
>>>>>>> 80e6ee6b7050ef3d5129378af4bf9db088d4bade
    ];
}

//https://api.gimcloud.com/gimcloudzafiro/api/5