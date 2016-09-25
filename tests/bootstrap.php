<?php
require __DIR__ . '/../vendor/autoload.php';
define('ROOT_PATH', __DIR__ . '/..');

$openrefineHost = "localhost";
if (getenv("OPENREFINE_HOST")) {
    $openrefineHost = getenv("OPENREFINE_HOST");
}
$openrefinePort = 3333;
if (getenv("OPENREFINE_PORT")) {
    $openrefinePort = getenv("OPENREFINE_PORT");
}

// test if openrefine server is running
$client = new \GuzzleHttp\Client([
    "base_uri" => "http://" . $openrefineHost . ":" . $openrefinePort
]);
$proxy = new \Retry\RetryProxy(
    new \Retry\Policy\SimpleRetryPolicy(5),
    new \Retry\BackOff\ExponentialBackOffPolicy(10000)
);
$proxy->call(function () use ($client) {
    try {
        $response = $client->get("/");
    } catch (\GuzzleHttp\Exception\ConnectException $e) {
        throw new \Exception("OpenRefine not available: " . $e->getMessage());
    }
    if (strripos($response->getBody()->__toString(), "Butterfly")) {
        throw new \Exception("OpenRefine not initialized");
    }
});
