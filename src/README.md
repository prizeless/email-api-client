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
      "url": "https://github.com/prizeless/email-api.git"
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

```
#!sh
TAP version 13
ok 1 - Communication\Tests\Senders\Email\SingleMessageTest::testSetMessage_WithAllVariables_ShouldSetMessage
ok 2 - Communication\Tests\Senders\Email\SingleMessageTest::testSetMessage_WithInvalidEmail_ShouldThrowException
ok 3 - Communication\Tests\Senders\Email\SingleMessageTest::testSetMessage_WithNoFromName_ShouldThrowException
ok 4 - Communication\Tests\Senders\Email\SingleMessageTest::testAddContact_WithAllVariables_ShouldSetContact
ok 5 - Communication\Tests\Senders\Email\SingleMessageTest::testSetContact_WithInvalidEmail_ShouldThrowException
ok 6 - Communication\Tests\Senders\Email\SingleMessageTest::testSetMessage_WithNoFirstName_ShouldThrowException
1..6
```