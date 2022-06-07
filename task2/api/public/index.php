<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

use App\Application;

require_once dirname(__DIR__) . '/vendor/autoload.php';

parse_str(parse_url($_SERVER['REQUEST_URI'])['query'], $request_params);
$request_body_json = file_get_contents("php://input");
$request_body = json_decode($request_body_json, true);

$request = array(
	"request_params" => $request_params,
	"request_body" => $request_body
);

$application = new Application();

$application->run($request);
