<?php
/**
 * Created by PhpStorm.
 * User: ondra
 * Date: 24/09/16
 * Time: 12:06
 */

namespace Keboola\Transformation;

use Keboola\Csv\CsvFile;
use Keboola\OpenRefine\Client;
use Keboola\OpenRefine\Exception;

class OpenRefine
{
    /**
     * @var string
     */
    protected $host = "localhost";

    /**
     * @var int
     */
    protected $port = 3333;

    /**
     * OpenRefine constructor.
     *
     * @param string $host
     * @param int $port
     */
    public function __construct($host = "localhost", $port = 3333)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * @param $in
     * @param $out
     * @param $operations
     * @throws Exception
     */
    public function run($in, $out, $operations)
    {
        $client = new Client($this->host, $this->port);
        $csv = new CsvFile($in);
        try {
            $projectId = $client->createProject($csv, "Transformation Test");
            $client->applyOperations($projectId, $operations);
            $client->exportRowsToCsv($projectId, $out);
            $client->deleteProject($projectId);
        } catch (Exception $e) {
            throw new Exception("Error processing OpenRefine operations: {$e->getMessage()}");
        }
    }
}
