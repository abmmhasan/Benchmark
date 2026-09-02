<?php
/*
    PHP-Frameworks-Bench
    this is a simple hello world controller to make benchmark
 */
namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class HelloWorld extends BaseController
{
    public function index(mixed ...$values): string
    {
        return 'Hello World!';
    }

    public function methodNotAllowed(): ResponseInterface
    {
        return $this->response
            ->setHeader('Allow', 'GET')
            ->setStatusCode(405)
            ->setBody('Method Not Allowed');
    }
}
