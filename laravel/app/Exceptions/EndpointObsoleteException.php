<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class EndpointObsoleteException extends HttpException
{
    protected $slug = 'endpoint_obsolete';
    protected $statusCode = 410;

    public function __construct($message)
    {
        parent::__construct($this->statusCode, $message);
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function render($request)
    {
        $debug = config('app.debug');
        $data = [
            'message' => $this->getMessage(),
            'slug' => $this->slug
        ];
        if ($debug) {
            $data['trace'] = $this->getTrace();
            $data['line'] = $this->getLine();
            $data['file'] = $this->getFile();
        }
        return response()->json($data, $this->statusCode);
    }
}