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

try {
    $transformation = new \Keboola\Transformation\OpenRefine();
    $result = $transformation->run($arguments["data"] . "/in/tables/data.csv", $arguments . "/out/tables/data.csv", $config["parameters"]["script"][0]);
} catch (\Keboola\Transformation\Exception $e) {
    print $e->getMessage();
    exit(1);
}
print $result;
exit(0);
