<?php
namespace Communication\Reports;

use Communication\Definitions\Config;
use Communication\Definitions\Reports;
use Communication\Exceptions\RequestException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;

class Report
{
    private $messageId;

    private $startDate;

    private $endDate;

    private $config;

    private $client;

    public function __construct($message, $startDate = 0, $endDate = 0)
    {
        $this->messageId = $message;

        $this->startDate = '/' . $endDate;

        $this->endDate = '/' . $endDate;
    }

    public function overview()
    {
        return $this->getReport(Reports::OVERVIEW);
    }

    public function clicks()
    {
        return $this->getReport(Reports::CLICKS);
    }

    public function opens()
    {
        return $this->getReport(Reports::OPENS);
    }

    public function bounces()
    {
        return $this->getReport(Reports::BOUNCES);
    }

    public function spamReports()
    {
        return $this->getReport(Reports::SPAM);
    }

    private function getReport($reportType = '')
    {
        try {
            $response = $this->getClient()->get(
                $this->getConfig()->apiBaseUrl
                . Reports::URL
                . $this->messageId
                . $reportType
                . $this->startDate
                . $this->endDate,
                ['auth' => [$this->getConfig()->apiUser, $this->getConfig()->apiPassword]]
            );

            return $response->getBody()->read($response->getBody()->getSize());
        } catch (ClientException $e) {
            throw new RequestException($e->getMessage());
        } catch (GuzzleRequestException $e) {
            throw new RequestException($e->getMessage());
        }
    }

    private function getClient()
    {
        if (empty($this->client) === true) {
            $this->client = new Client;
        }

        return $this->client;
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    private function getConfig()
    {
        if (empty($this->config) === true) {
            $this->config = new Config;
        }

        return $this->config;
    }

    public function setConfig(Config $config)
    {
        $this->config = $config;
    }
}
