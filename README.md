# ParserText

This is a PHP class to parse the text using the template.

## Installation

```
composer require zualex/parsertext
```

## Exmaple

```php
require_once __DIR__ . '/vendor/autoload.php';

use \ParserText\ParserText;

$parserSms = new ParserText('
    Никому не говорите пароль! Его спрашивают только мошенники.
    Пароль: {% password %}
    Перевод на счет {% receiver %}
    Вы потратите {% sum %}р.
');

$parserSms->run('
    Никому не говорите пароль! Его спрашивают только мошенники.
    Пароль: 72946
    Перевод на счет 410011068150008
    Вы потратите 5025,13р.
'));
```

Result:
```
[
    'password' => '72946',
    'receiver' => '410011068150008',
    'sum' => '5025,13',
]
```
