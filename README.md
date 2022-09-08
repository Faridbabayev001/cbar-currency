# PHP library to work with [CBAR](https://www.cbar.az/home?language=en) currency rates

<p align="center">
<img src="https://raw.githubusercontent.com/Faridbabayev001/cbar-currency/master/screenshot.png" />
</p>

## Requirements

**PHP 7.4** or higher, ``simplexml`` and ``bcmath`` extensions.

## Installation

```bash
composer require faridbabayev/cbar-currency
php artisan vendor:publish --provider="FaridBabayev\CBARCurrency\CBARCurrencyServiceProvider"
```
## Usage
### Fetching currencies from CBAR

Instantiate ``FaridBabayev\CBARCurrency\Facades\CBAR`` with date you want to fetch currencies for. If you don't pass a date, current date will be used:

```php
use FaridBabayev\CBARCurrency\Facades\CBAR;

$currencies = CBAR::currencies(); // this will fetch currencies for current date
$currencies = CBAR::from("18.02.2022")->currencies(); // this will fetch currencies for 18.02.2022
```

You can pass dates in any format that acceptable by PHP's ``strtotime()`` function.
For example, ``20.10.2022``, ``10/20/2022``, ``2022-10-20``, ``today``, ``yesterday``, ``-1 week``, ``-1 year``, ``15 December 2020``, ``last Friday``.

### Use available drivers

You can change default driver from env file.
```env
CBAR_CONNECTION=database
```

1. Default driver is ```sync```:
```php
use FaridBabayev\CBARCurrency\Facades\CBAR;

$currencies = CBAR::currencies(); // this will fetch currencies for current date
$currencies = CBAR::from("18.02.2022")->currencies(); // this will fetch currencies for 18.02.2022
```
2. You can use ```database``` driver. Before use ```database``` driver first run ```php artisan migrate``` for ```currencies```table:
```php
use FaridBabayev\CBARCurrency\Facades\CBAR;

$currencies = CBAR::driver('database')->currencies(); // this will fetch currencies for current date
$currencies = CBAR::driver('database')->from("18.02.2022")->currencies(); // this will fetch currencies for 18.02.2022
```
3. You can use ```file``` driver:
```php
use FaridBabayev\CBARCurrency\Facades\CBAR;

$currencies = CBAR::driver('file')->currencies(); // this will fetch currencies for current date
$currencies = CBAR::driver('file')->from("18.02.2022")->currencies(); // this will fetch currencies for 18.02.2022
```

## Converting currency

All available currencies and currency codes can be found in [CBAR website](https://www.cbar.az/currency/rates?language=en)

### Converting amount to and from AZN
Library supports converting given amount in foreign currency to AZN with given date's rates:

```php
$currencies = CBAR::currencies();
$currencies->toAZN('USD')->convert(); // returns AZN equivalent of 1.00 USD with today's currencies
$currencies->toAZN('USD')->convert(25.53); // returns AZN equivalent of 25.53 USD with today's currencies
```
You can also convert given amount in AZN to any available foreign currency:
```php
$currencies = CBAR::currencies();
$currencies->fromAZN('USD')->convert(); //  returns USD equivalent of 1.00 AZN with today's currencies
$currencies->fromAZN('USD')->convert(25.53); //  returns USD equivalent of 25.53 AZN with today's currencies
```
## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email faridbabayev98@gmail.com instead of using the issue tracker.

## Credits

- [Farid Babayev](https://github.com/Faridbabayev001)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
