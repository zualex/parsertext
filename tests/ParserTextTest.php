<?php

use \ParserText\ParserText;

class ParserTextTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccess()
    {
        $parserSms = new ParserText('
            Никому не говорите пароль! Его спрашивают только мошенники.
            Пароль: {% password %}
            Перевод на счет {% receiver %}
            Вы потратите {% sum %}р.
        ');

        $this->assertEquals($parserSms->run('
            Никому не говорите пароль! Его спрашивают только мошенники.
            Пароль: 72946
            Перевод на счет 410011068150008
            Вы потратите 5025,13р.
        '), [
            'password' => '72946',
            'receiver' => '410011068150008',
            'password' => '5025,13',
        ]);
    }
}
