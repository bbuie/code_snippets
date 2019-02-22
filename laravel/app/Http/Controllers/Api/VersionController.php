<?php

namespace App\Http\Controllers\Api;

use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Exceptions\EndpointObsoleteException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    public function endpointObsolete(Request $request)
    {
        throw new EndpointObsoleteException("Support for this DYM endpoint has been discontinued.");
    }
}