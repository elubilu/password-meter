# password-meter
[Password Meter] (https://packagist.org/packages/elubilu/password-meter) is inspired by pointing system of Password Entropy, in which the main purpose is to help the end-users to have stronger passwords. (Password entropy is a measurement of how unpredictable a password is.)


## Installation

Use the package manager [composer](https://packagist.org/packages/elubilu/password-meter) to install [Password Meter] (https://packagist.org/packages/elubilu/password-meter).

```bash
composer require elubilu/password-meter

```

## Usage

It's very easy configure on your application. just follow on below: 

```php


$app =  new passwordMeter\passwordMeter();
$app->password_strength("1111"); // return  message = "Very Weak" , strength = 14  , percentage = 11%
$app->password_strength("aaaa"); // return  message = "Very Weak" , strength = 19 , percentage = 15%
$app->password_strength("####"); // return  message = "Very Weak" , strength = 21 , percentage = 17%
$app->password_strength("banglad"); // return  message = "Weak" , strength = 33  , percentage = 26%
$app->password_strength("bangla1"); // return  message = "Good" , strength = 37  , percentage = 29%
$app->password_strength("bangladesh"); // return  message = "Good" , strength = 48  , percentage = 38%
$app->password_strength("bangla1desh"); // return  message = "Good" , strength = 57 , percentage = 45%
$app->password_strength("Bangla1desh"); // return  message = "Strong", strength = 66, percentage = 52%
$app->password_strength("Bangladesh#"); // return  message = "Strong", strength = 71, percentage = 56%
$app->password_strength("Bangla1desh#"); // return  message = "Strong", strength = 79, percentage = 62%
$app->password_strength("Hello71*Bangla1desh#"); // return  message = "Very Strong" , strength = 132  , percentage = 100%
```

There are some default messages,
```php
$app =  new passwordMeter\passwordMeter();
$app->get_messages();
// Example: default messages of package, 
Array
(
    [VERY_WEAK] => Very Weak
    [WEAK] => Weak
    [GOOD] => Good
    [STRONG] => Strong
    [VERY_STRONG] => Very Strong
)

```

There are some default configs,
```php
$app =  new passwordMeter\passwordMeter();
$app->get_configs();
// Example: default configs of package, 
Array
(
    [SMALL_LETTER] => Array
        (
            [min] => 0
            [max] => 26
        )

    [CAPITAL_LETTER] => Array
        (
            [min] => 0
            [max] => 26
        )

    [NUMERIC] => Array
        (
            [min] => 0
            [max] => 255
        )

    [SPECIAL_CHAR] => Array
        (
            [min] => 0
            [max] => 33
        )

)

```


## Contributing
Pull requests are welcome. For any changes, please open an issue first to discuss what you would like to change.

Please make sure to update the tests as appropriate.

## License
[MIT](https://github.com/elubilu/password-meter/blob/master/LICENSE)













