Russian text uniqifier
======================
Class to uniqify russian text.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist tugmaks/russian-text-uniqifier "*"
```

or add

```
"tugmaks/russian-text-uniqifier": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once this class is installed, simply use it in your code by  :

```php
$text = "Что случилось с этим миром,
Или сдулся шар земной?
Все переменилось мигом -
Все случилось мирно,
Все промчалось мимо -
Я иду домой.
(Вниз головой).

Этот мир перевернулся,
И завис передо мной.
Вокруг света обернулся;
Убежал, вернулся,
Закричал, качнулся,
Я иду - я падаю, падаю, падаю вниз головой,
Я падаю вниз головой!

Прощай навсегда, шар земной!
Но мы расстаемся с тобой,
Со всей разноцветной листвой.
Я падаю вниз головой!
Со всей разноцветной листвой!
Прощай навсегда, шар земной,
Но мы расстаемся с тобой,
Со всей разноцветной листвой.
Я падаю вниз головой!

Ты, пожалуйста, не бойся
Так случается со мной.
Ни о чем не беспокойся -
На замок закройся,
С головой укройся -
Я иду домой,
Я иду домой,
Я иду домой!";
echo \tugmaks\RTU\Uniqifier($text);
```