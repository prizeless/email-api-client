<?php
namespace Communication\Definitions;

class Message
{
    public $customer_id;

    public $message_id;

    public $html;

    public $subject;

    public $from_email;

    public $from_name;

    public function __construct($customerId, $messageId, $html, $subject, $fromEmail, $fromName)
    {
        $this->customer_id = $customerId;

        $this->message_id = $messageId;

        $this->html = $html;

        $this->subject = $subject;

        $this->from_email = $fromEmail;

        $this->from_name = $fromName;
    }
}
