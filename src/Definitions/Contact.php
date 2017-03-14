<?php
namespace Communication\Definitions;

use Communication\Utilities\Utility;

class Contact
{
    public $member_id;

    public $full_name;

    public $email;

    /**
     * @param mixed $contactId
     * @param string $firstName
     * @param string $email
     * @param string $lastName
     */
    public function __construct($contactId, $email, $firstName, $lastName = '')
    {
        $this->member_id = $contactId;

        $this->full_name = (new Utility)->spaceLess($firstName . ' ' . $lastName);

        $this->email = $email;
    }
}
