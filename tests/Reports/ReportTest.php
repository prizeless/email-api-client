<?php

class ReportTest extends \PHPUnit_Framework_TestCase
{
    public function testOverView_WithMessageId_ShouldReturnReport()
    {
        $report = new \Communication\Reports\Report(1);

        $this->processMocks($report, 'overView');

        $result = $report->overview();

        $this->assertEquals('report', $result);
    }

    private function processMocks($report, $reportType)
    {
        $guzzleResponse = \Mockery::mock('Guzzle\Psr7\Response');
        $client = \Mockery::mock('GuzzleHttp\Client');
        $client->shouldReceive('get')
            ->once()
            ->with(
                'http://blahblahfishpaste.co.za/api/v1/messages/email/report/1/' . $reportType . '/0/0',
                ['auth' => ['test', 'test']]
            )
            ->andReturn($guzzleResponse);
        $report->setClient($client);


        $guzzleResponse->shouldReceive('getBody')
            ->once()
            ->andReturn($guzzleResponse);

        $guzzleResponse->shouldReceive('read')->once()->andReturn('report');

        $guzzleResponse->shouldReceive('getSize')->once()->andReturn('32');
    }

    public function testClciks_WithMessageIdAndDates_ShouldReturnReport()
    {
        $report = new \Communication\Reports\Report(1, '123456789', '123456789');

        $guzzleResponse = \Mockery::mock('Guzzle\Psr7\Response');

        $client = \Mockery::mock('GuzzleHttp\Client');
        $report->setClient($client);

        $client->shouldReceive('get')
            ->once()
            ->with(
                'http://blahblahfishpaste.co.za/api/v1/messages/email/report/1/clicks/123456789/123456789',
                ['auth' => ['test', 'test']]
            )
            ->andReturn($guzzleResponse);

        $guzzleResponse->shouldReceive('getBody')
            ->once()
            ->andReturn($guzzleResponse);

        $guzzleResponse->shouldReceive('read')->once()->andReturn('report');

        $guzzleResponse->shouldReceive('getSize')->once()->andReturn('32');

        $result = $report->clicks();

        $this->assertEquals('report', $result);
    }

    public function testBounces_WithMessageId_ShouldReturnReport()
    {
        $report = new \Communication\Reports\Report(1);

        $this->processMocks($report, 'bounces');

        $result = $report->bounces();

        $this->assertEquals('report', $result);
    }

    public function testOpens_WithMessageId_ShouldReturnReport()
    {
        $report = new \Communication\Reports\Report(1);

        $this->processMocks($report, 'opens');

        $result = $report->opens();

        $this->assertEquals('report', $result);
    }

    public function testSpamReport_WithMessageId_ShouldReturnReport()
    {
        $report = new \Communication\Reports\Report(1);

        $this->processMocks($report, 'spamreport');

        $result = $report->spamReports();

        $this->assertEquals('report', $result);
    }
}
