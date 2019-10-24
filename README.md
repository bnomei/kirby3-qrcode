# Kirby 3 QRCode

![Release](https://flat.badgen.net/packagist/v/bnomei/kirby3-qrcode?color=ae81ff)
![Stars](https://flat.badgen.net/packagist/ghs/bnomei/kirby3-qrcode?color=272822)
![Downloads](https://flat.badgen.net/packagist/dt/bnomei/kirby3-qrcode?color=272822)
![Issues](https://flat.badgen.net/packagist/ghi/bnomei/kirby3-qrcode?color=e6db74)
[![Build Status](https://flat.badgen.net/travis/bnomei/kirby3-qrcode)](https://travis-ci.com/bnomei/kirby3-qrcode)
[![Coverage Status](https://flat.badgen.net/coveralls/c/github/bnomei/kirby3-qrcode)](https://coveralls.io/github/bnomei/kirby3-qrcode) 
[![Maintainability](https://flat.badgen.net/codeclimate/maintainability/bnomei/kirby3-qrcode)](https://codeclimate.com/github/bnomei/kirby3-qrcode) 
[![Demo](https://flat.badgen.net/badge/website/examples?color=f92672)](https://kirby3-plugins.bnomei.com/autoid) 
[![Gitter](https://flat.badgen.net/badge/gitter/chat?color=982ab3)](https://gitter.im/bnomei-kirby-3-plugins/community) 
[![Twitter](https://flat.badgen.net/badge/twitter/bnomei?color=66d9ef)](https://twitter.com/bnomei)

Generate QRCodes easily.

## Commercial Usage

This plugin is free but if you use it in a commercial project please consider to 
- [make a donation 🍻](https://www.paypal.me/bnomei/5) or
- [buy me ☕](https://buymeacoff.ee/bnomei) or
- [buy a Kirby license using this affiliate link](https://a.paddle.com/v2/click/1129/35731?link=1170)

## Installation

- unzip [master.zip](https://github.com/bnomei/kirby3-qrcode/archive/master.zip) as folder `site/plugins/kirby3-qrcode` or
- `git submodule add https://github.com/bnomei/kirby3-qrcode.git site/plugins/kirby3-qrcode` or
- `composer require bnomei/kirby3-qrcode`

## Usecase

### Raw PHP

```php
$qrcodeObject = new \Bnomei\QRCode([
    'Text' => 'https://github.com/bnomei/kirby3-qrcode',
]);
echo $qrcodeObject->html();
```

### Page Method

**site/templates/default.php**
```php
// base64 encoded png image tag
// with $page->url() as Text
echo $page->qrcode()->html(
    $page->slug() . '.png' // image format detected from extension
);
```

### Trigger download

**site/templates/default.qr.php**
```php
$page->qrcode()->download(
    $page->slug() . '.svg'
);
```

### Further customization of the generated image

[Advanced options](https://github.com/endroid/qr-code#advanced-usage) can be set.
```php
echo $page->qrcode([
    'Margin' => 10,
    'Encoding' => 'UTF-8',
    'ForegroundColor' => ['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0],
    'BackgroundColor' => ['r' => 255, 'g' => 255, 'b' => 255, 'a' > 0]),
    'Label' => ['Scan the code', 16, __DIR__.'/../assets/fons/noto_sans.otf', LabelAlignment::CENTER];
    'LogoPath' => __DIR__.'/../assets/images/getkirby.png',
    'LogoSize' => [150, 200],
    'RoundBlockSize' => true,
])->html(
    $page->slug() . '.png'
);
```

> Attention: In this plugin options are single value or an array.

## Dependencies

- [Endroid/QR-Code](https://github.com/endroid/qr-code)

## Disclaimer

This plugin is provided "as is" with no guarantee. Use it at your own risk and always test it yourself before using it in a production environment. If you find any issues, please [create a new issue](https://github.com/bnomei/kirby3-qrcode/issues/new).

## License

[MIT](https://opensource.org/licenses/MIT)

It is discouraged to use this plugin in any project that promotes racism, sexism, homophobia, animal abuse, violence or any other form of hate speech.

## Credits

based on V2 versions of
- https://github.com/bnomei/kirby-qrcode
