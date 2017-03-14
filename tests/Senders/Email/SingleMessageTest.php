<?php
namespace Communication\Tests\Senders\Email;

use Communication\Definitions\Contact;
use Communication\Definitions\EmailPacket;
use Communication\Definitions\Message;
use Communication\Senders\Email\SingleMessage;

class SingleMessageTest extends \PHPUnit_Framework_TestCase
{

    public function testSend_WithValidMessage_ShouldSend()
    {
        $sender = new SingleMessage();
        $sender->setMessage(1, 1, '<body>Testing</body>', 'Subject', 'antony@prizeless.net', 'antony@prizeless.net');
        $sender->addContact(1, 'antony@prizeless.net', 'Antony');

        $message = new EmailPacket(
            new Message(1, 1, '<body>Testing</body>', 'Subject', 'antony@prizeless.net', 'antony@prizeless.net'),
            new Contact(1, 'antony@prizeless.net', 'Antony')
        );

        $guzzleResponse = \Mockery::mock('Guzzle\Psr7\Response');
        $client = \Mockery::mock('GuzzleHttp\Client');
        $sender->setClient($client);


        $config = \Mockery::mock('Communication\Definitions\Config');
        $config->apiBaseUrl = 'http://testing.com/api/v1';
        $config->apiUser = 'testing';
        $config->apiPassword = 'testing';
        $sender->setConfig($config);

        $client->shouldReceive('post')
            ->once()
            ->with(
                'http://testing.com/api/v1/messages/email/send',
                [
                    'auth' => ['testing', 'testing'],
                    'json' => $message
                ]
            )
            ->andReturn($guzzleResponse);

        $guzzleResponse->shouldReceive('getStatusCode')->once()->andReturn(200);

        $streamInterface = \Mockery::mock('Psr\Http\Message\StreamInterface');
        $streamInterface->shouldReceive('read')->once()->andReturn('Your message has been queued.');

        $guzzleResponse->shouldReceive('getBody')->once()->andReturn($streamInterface);

        $sender->send();
    }

    public function testSetMessage_WithAllVariables_ShouldSetMessage()
    {
        $sender = new SingleMessage;
        $sender->setMessage(1, 1, '<body>Testing</body>', 'Subject', 'antony@prizeless.net', 'Antony Masocha');

        $class = new \ReflectionMethod('Communication\Senders\Email\SingleMessage', 'getMessage');
        $class->setAccessible(true);
        $result = $class->invoke($sender);

        $expected = new Message(1, 1, '<body>Testing</body>', 'Subject', 'antony@prizeless.net', 'Antony Masocha');

        $this->assertEquals($expected, $result);
    }

    public function testSetMessage_WithInvalidEmail_ShouldThrowException()
    {
        $this->setExpectedException(
            'Communication\Exceptions\Validation',
            'Validation rule email antonyprizeless.co.za is invalid failed.'
        );
        $sender = new SingleMessage;
        $sender->setMessage(1, 1, '<body>Testing</body>', 'Subject', 'antonyprizeless.co.za', 'Antony Masocha');
    }

    public function testSetMessage_WithNoFromName_ShouldThrowException()
    {
        $this->setExpectedException(
            'Communication\Exceptions\Validation',
            'Validation rule value from_name must be set failed'
        );
        $sender = new SingleMessage;
        $sender->setMessage(1, 1, '<body>Testing</body>', 'Subject', 'antony@prizeless.net', '');
    }

    public function testAddContact_WithAllVariables_ShouldSetContact()
    {
        $sender = new SingleMessage;

        $sender->addContact(1, 'antony@prizeless.net', 'Antony', 'Masocha');

        $class = new \ReflectionMethod('Communication\Senders\Email\SingleMessage', 'getContacts');
        $class->setAccessible(true);
        $result = $class->invoke($sender);

        $expected = new Contact(1, 'antony@prizeless.net', 'Antony', 'Masocha');

        $this->assertEquals($expected, $result);
    }

    public function testSetContact_WithInvalidEmail_ShouldThrowException()
    {
        $this->setExpectedException(
            'Communication\Exceptions\Validation',
            'Validation rule email antonyprizeless.co.za is invalid failed.'
        );
        $sender = new SingleMessage;
        $sender->addContact(1, 'antonyprizeless.co.za', 'Antony');
    }

    public function testSetMessage_WithNoFirstName_ShouldThrowException()
    {
        $this->setExpectedException(
            'Communication\Exceptions\Validation',
            'Validation rule value full_name must be set failed.'
        );
        $sender = new SingleMessage;
        $sender->addContact(1, 'antony@prizeless.net', '');
    }
}
