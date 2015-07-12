# xOrder PHP Library

[![Build Status](https://img.shields.io/travis/craftt/xorder-php-sdk.svg?style=flat-square)](https://travis-ci.org/craftt/xorder-php-sdk)
[![Quality Score](https://img.shields.io/scrutinizer/g/craftt/xorder-php-sdk.svg?style=flat-square)](https://scrutinizer-ci.com/g/craftt/xorder-php-sdk)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/craftt/xorder-php-sdk.svg?style=flat-square)](https://scrutinizer-ci.com/g/craftt/xorder-php-sdk/code-structure)
[![Latest Version](https://img.shields.io/github/release/craftt/xorder-php-sdk.svg?style=flat-square)](https://github.com/craftt/xorder-php-sdk/releases)
[![Software License](https://img.shields.io/badge/license-APACHE2-blue.svg?style=flat-square)](LICENSE.md)

The xOrder PHP SDK makes it easy to integrate your order and inventory sytsems with [ContainerWorld's](http://containerworld.com) [xOrder](http://xorder.ca) EDI service.  It leverages the powerful [Guzzle](https://github.com/guzzle/guzzle) library to make http requests.

## Usage

Examples of how the xOrder PHP SDK can be used are located in the examples directory.

```php
$xorder = new XOrder\XOrder('xorder.xml', true);
$credentials = new XOrder\Credentials('uesrname', 'password', 'account');

$client = new XOrder\Client;
$client->login($credentials);

$response = $client->send($xorder);
```

## Testing

The xOrder PHP SDK has a [PHPUnit](https://phpunit.de/) test suite. To run the tests, run the following command from the project folder:

```bash
$ phpunit
```
## Contributing

Contributions are welcome and will be fully credited. Please see [CONTRIBUTING](https://github.com/craftt/xorder-php-sdk/blob/master/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email hello@craftt.com instead of using the issue tracker.

## License

Apache 2.0.  Please see [LICENSE](https://github.com/craftt/xorder-php-sdk/blob/master/LICENSE.md) for more information.
