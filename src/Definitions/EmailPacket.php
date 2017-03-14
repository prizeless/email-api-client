<?php

namespace Communication\Definitions;

class EmailPacket
{
    public $message;

    public $recipient;

    public $attachments;

    /**
     * @param Message $message
     * @param $contact
     * @param array $attachments
     */
    public function __construct(Message $message, $contact, $attachments = [])
    {
        $this->message = $message;

        $this->attachments = $attachments;

        $this->recipient = $contact;
    }
}
