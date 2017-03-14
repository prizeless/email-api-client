EMAIL API PHP client
============================

Send messages to email api system

In your composer.json file

```
#!json
{
  "repositories": [
    {
      "type": "vcs",
      "url": ".git"
    }
  ],
  "require": {
    "php": ">=5.5.0",
    "prizeless/email-api-client": "dev-master"
  }
}
```

```
#!sh
 composer update
```

```
#!php
try {
    $sender = new \Communication\Senders\Email\SingleMessage();
    $sender->setMessage(1, 1, '<body>Testinf intergration</body>', 'subject', 'antony@prizeless.net', 'Antony Masocha');
    $sender->addContact(1, 'antony@prizeless.net', 'Antony');
    $sender->addAttachment(dirname(__FILE__) . '/testing.txt', 'munhu_mukuru_umwe');
    $res = $sender->send();

    print_r($res);

} catch (Communication\Exceptions\RequestException $e) {
    echo $e->getMessage();
}
```
Get reports of messages sent
```
#!php
try {
    $reports = new \Communication\Reports\Report($messageId = 1, $startDate = '0', '0');
    $overview = $reports->overview();
    print_r(json_decode($overview));
} catch (Communication\Exceptions\RequestException $e) {
    echo $e->getMessage();

Array
(
    [0] => stdClass Object
        (
            [id] => 2
            [message_id] => 1
            [sg_message_id] => 0
            [contact_identifier] => 7570d79630420056012602be668a86bc
            [member_id] => 12875
            [customer_id] => 214
            [status] => sent
            [status_reason] =>
            [delivered_at] => 0
            [opened_at] => 0
            [created_at] => 1443621327
            [link_clicks] => Array
                (
                )

        )

    [1] => stdClass Object
        (
            [id] => 1
            [message_id] => 1
            [sg_message_id] => 0
            [contact_identifier] => a3509defdb395407313935cbe84bb6c1
            [member_id] => 12874
            [customer_id] => 214
            [status] => sent
            [status_reason] =>
            [delivered_at] => 0
            [opened_at] => 0
            [created_at] => 1443621327
            [link_clicks] => Array
                (
                )

        )

)

```

```
#!sh
TAP version 13
ok 1 - ReportTest::testOverView_WithMessageId_ShouldReturnReport
ok 2 - ReportTest::testClciks_WithMessageIdAndDates_ShouldReturnReport
ok 3 - ReportTest::testBounces_WithMessageId_ShouldReturnReport
ok 4 - ReportTest::testOpens_WithMessageId_ShouldReturnReport
ok 5 - ReportTest::testSpamReport_WithMessageId_ShouldReturnReport
ok 6 - Communication\Tests\Senders\Email\SingleMessageTest::testSend_WithValidMessage_ShouldSend
ok 7 - Communication\Tests\Senders\Email\SingleMessageTest::testSetMessage_WithAllVariables_ShouldSetMessage
ok 8 - Communication\Tests\Senders\Email\SingleMessageTest::testSetMessage_WithInvalidEmail_ShouldThrowException
ok 9 - Communication\Tests\Senders\Email\SingleMessageTest::testSetMessage_WithNoFromName_ShouldThrowException
ok 10 - Communication\Tests\Senders\Email\SingleMessageTest::testAddContact_WithAllVariables_ShouldSetContact
ok 11 - Communication\Tests\Senders\Email\SingleMessageTest::testSetContact_WithInvalidEmail_ShouldThrowException
ok 12 - Communication\Tests\Senders\Email\SingleMessageTest::testSetMessage_WithNoFirstName_ShouldThrowException
1..12

```
