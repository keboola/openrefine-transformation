<?php

namespace Keboola\Processor\LastFile\Tests;

use Keboola\Transformation\Exception;
use Keboola\Transformation\OpenRefine;
use PHPUnit\Framework\TestCase;

class OpenRefineTest extends TestCase
{
    public function testRun()
    {
        if (file_exists(__DIR__ . "/../../data/out/tables/data.csv")) {
            unlink(__DIR__ . "/../../data/out/tables/data.csv");
        }
        $transformation = new OpenRefine(getenv("OPENREFINE_HOST"), getenv("OPENREFINE_PORT"));
        $inFile = __DIR__ . "/../../data/in/tables/data.csv";
        $outFile = __DIR__ . "/../../data/out/tables/data.csv";
        $config = json_decode(file_get_contents(__DIR__ . "/../../data/config.json"), true);
        $operations = json_decode($config["parameters"]["script"][0], true);
        $transformation->run($inFile, $outFile, $operations);
        $this->assertFileEquals(__DIR__ . "/../../data/expected.csv", __DIR__ . "/../../data/out/tables/data.csv");
    }
}
