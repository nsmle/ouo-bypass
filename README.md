# Ouo.io Bypass


A PHP library to bypass short links [ouo.io](https://ouo.io) or [ouo.press](https://ouo.press).

If you like or use this package, please share your love by starring this repository, or follow [@nsmle](https://github.com/nsmle).

## Installation
```bash
composer require nsmle/ouo-bypass
```

## Usage
```php
require 'vendor/autoload.php';

use Nsmle\OuoBypass\Api;

$ouo = new Api();
$ouo->setOriginUrl("https://ouo.press/ZGawzS");
$ouo->bypass();
$link = $ouo->getDestinationUrl();

echo $link;
```

Or if you want something simpler you can try some code like below:

```php
$ouo = new Api("https://ouo.press/ZGawzS");
$ouo->bypass();
$link = $ouo->getDestinationUrl();
```
or
```php
$ouo = new Api("https://ouo.press/ZGawzS");
$link = $ouo->bypass()['destination-url'];
```

## License

Licensed under the terms of the [MIT License](https://github.com/nsmle/ouo-bypass/blob/main/LICENSE).