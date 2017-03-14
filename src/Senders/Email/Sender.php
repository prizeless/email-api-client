<?php

namespace Communication\Senders\Email;

use Communication\Definitions\Attachment;
use Communication\Definitions\Config;
use Communication\Definitions\EmailPacket;
use Communication\Definitions\Message;
use Communication\Exceptions\RequestException;
use Communication\Utilities\Response;
use Communication\Utilities\Validator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;

abstract class Sender
{
    private $message;

    private $client;

    protected $contacts;

    private $attachments = [];

    private $validator;

    protected $requestUri = '/';

    private $config;

    /**
     * Set the message to be sent
     * @param mixed $customerId 255 chars max The customer identifier code You will need this to pull reports
     * @param mixed $messageId 255 chars max The message identifier
     * @param string $html UTF-8 message html content
     * @param string $subject UTF-8 message subject
     * @param string $fromEmail email address to show in the from block
     * @param string $fromName The name to show in the from name block
     */

    public function setMessage($customerId, $messageId, $html, $subject, $fromEmail, $fromName)
    {
        $this->getValidator()->validateEmail($fromEmail);

        $this->message = new Message($customerId, $messageId, $html, $subject, $fromEmail, $fromName);

        $this->getValidator()->validateRequiredObject($this->message);
    }

    /**
     * @param $validator Validator
     */
    protected function setValidator(Validator $validator)
    {
        $this->validator = $validator;
    }

    protected function getValidator()
    {
        if (empty($this->validator) === true) {
            $this->validator = new Validator;
        }

        return $this->validator;
    }

    public function send()
    {
        try {
            $message = new EmailPacket($this->getMessage(), $this->getContacts(), $this->getAttachments());

            $response = $this->getClient()->post(
                $this->getConfig()->apiBaseUrl . $this->requestUri,
                [
                    'auth' => [$this->getConfig()->apiUser, $this->getConfig()->apiPassword],
                    'json' => $message
                ]
            );

            return new Response($response->getStatusCode(), $response->getBody()->read(1024));
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

    private function getMessage()
    {
        return $this->message;
    }

    protected function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param string $filePath File path
     * @param string $attachmentName The name to attache the file as
     */
    public function addAttachment($filePath, $attachmentName)
    {
        $this->attachments[] = new Attachment($filePath, $attachmentName);
    }

    private function getAttachments()
    {
        return $this->attachments;
    }

    public function setConfig(Config $config)
    {
        $this->config = $config;
    }

    abstract public function addContact($contactId, $email, $firstName, $lastName);
}
