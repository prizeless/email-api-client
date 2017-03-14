<?php

namespace Communication\Senders\Email;

use Communication\Definitions\Contact;

class BulkMessages extends Sender implements SenderInterface
{
    public function __construct($requestUri = '/messages/email/bulk/send', $contacts = [])
    {
        $this->requestUri = $requestUri;

        $this->contacts = $contacts;
    }

    public function addContact($contactId, $email, $firstName, $lastName = '')
    {
        $this->contacts[] = new Contact($contactId, $email, $firstName, $lastName);
    }

}
