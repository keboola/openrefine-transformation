<?php

require_once(dirname(__FILE__) . "/../vendor/autoload.php");

$arguments = getopt("d::", array("data::"));
if (!isset($arguments["data"])) {
    print "Data folder not set.";
    exit(1);
}

if (!file_exists($arguments["data"] . "/config.json")) {
    print "config.json file not found";
    exit(1);
}

$config = json_decode(file_get_contents($arguments["data"] . "/config.json"), true);

if (!isset($config["parameters"]["script"])) {
    print "Script not defined.";
    exit(1);
}

if (!file_exists($arguments["data"] . "/data/in/tables/data.csv")) {
    print "Source data file not found.";
    exit(1);
}

$openrefineHost = "localhost";
if (getenv("OPENREFINE_HOST")) {
    $openrefineHost = getenv("OPENREFINE_HOST");
}
$openrefinePort = 3333;
if (getenv("OPENREFINE_PORT")) {
    $openrefinePort = getenv("OPENREFINE_PORT");
}

// test if openrefine server is running
$client = new GuzzleHttp\Client([
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

try {
    $transformation = new \Keboola\Transformation\OpenRefine($openrefineHost, $openrefinePort);
    $outFile = $transformation->run($arguments["data"] . "/in/tables/data.csv", json_decode($config["parameters"]["script"][0], true));
    $filesystem = new \Symfony\Component\Filesystem\Filesystem();
    $filesystem->rename($outFile->getPathname(), $arguments["data"] . "/out/tables/data.csv");
    $filesystem->chmod($arguments["data"] . "/out/tables/data.csv", 0644);
} catch (\Keboola\Transformation\Exception $e) {
    print $e->getMessage();
    exit(1);
}
exit(0);
