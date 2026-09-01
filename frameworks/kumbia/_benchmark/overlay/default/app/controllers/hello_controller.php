<?php

class HelloController extends AppController
{

    public function index(mixed ...$values)
    {
        // View without template and view
        View::select(null, null);

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
            http_response_code(405);
            header('Allow: GET');
            echo 'Method Not Allowed';
            return;
        }

        echo 'Hello World!';
    }
}
