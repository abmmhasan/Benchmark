<?php 
/*
    PHP-Frameworks-Bench
    this is a simple hello world controller to make benchmark
 */
namespace App\Http\Controllers;

class HelloWorldController extends Controller {
    public function index() {
        ob_start();
        require dirname(__DIR__, 5) . '/libs/output_data.php';
        $telemetry = ob_get_clean();

        return response('Hello World!' . (is_string($telemetry) ? $telemetry : ''));
    }
}
