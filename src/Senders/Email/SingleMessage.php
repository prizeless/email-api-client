<?php
namespace Communication\Senders\Email;

use Communication\Definitions\Contact;

class SingleMessage extends Sender implements SenderInterface
{
    public function __construct($requestUri = '/messages/email/send')
    {
        $this->requestUri = $requestUri;
    }

    public function addContact($contactId, $email, $firstName, $lastName = '')
    {
        $this->getValidator()->validateEmail($email);

        $this->contacts = new Contact($contactId, $email, $firstName, $lastName);

        $this->getValidator()->validateRequiredObject($this->contacts);
    }
}
