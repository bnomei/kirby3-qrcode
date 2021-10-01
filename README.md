# Kirby 3 QRCode

![Release](https://flat.badgen.net/packagist/v/bnomei/kirby3-qrcode?color=ae81ff)
![Downloads](https://flat.badgen.net/packagist/dt/bnomei/kirby3-qrcode?color=272822)
[![Build Status](https://flat.badgen.net/travis/bnomei/kirby3-qrcode)](https://travis-ci.com/bnomei/kirby3-qrcode)
[![Coverage Status](https://flat.badgen.net/coveralls/c/github/bnomei/kirby3-qrcode)](https://coveralls.io/github/bnomei/kirby3-qrcode) 
[![Maintainability](https://flat.badgen.net/codeclimate/maintainability/bnomei/kirby3-qrcode)](https://codeclimate.com/github/bnomei/kirby3-qrcode) 
[![Twitter](https://flat.badgen.net/badge/twitter/bnomei?color=66d9ef)](https://twitter.com/bnomei)

Generate QRCodes easily. The included Panel-Field will show the QRCode and trigger download on click.

## Commerical Usage

> <br>
><b>Support open source!</b><br><br>
> This plugin is free but if you use it in a commercial project please consider to sponsor me or make a donation.<br>
> If my work helped you to make some cash it seems fair to me that I might get a little reward as well, right?<br><br>
> Be kind. Share a little. Thanks.<br><br>
> &dash; Bruno<br>
> &nbsp; 

| M | O | N | E | Y |
|---|----|---|---|---|
| [Github sponsor](https://github.com/sponsors/bnomei) | [Patreon](https://patreon.com/bnomei) | [Buy Me a Coffee](https://buymeacoff.ee/bnomei) | [Paypal dontation](https://www.paypal.me/bnomei/15) | [Buy a Kirby license using this affiliate link](https://a.paddle.com/v2/click/1129/35731?link=1170) |

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
    $page->slug() . '.png'
);
```

### Further customization of the generated image

[Advanced options](https://github.com/endroid/qr-code#usage-using-the-builder) can be set.
```php
echo $page->qrcode([
    'margin' => 10,
    'encoding' => 'UTF-8',
    'foregroundColor' => new \Endroid\QrCode\Color\Color(0, 0, 0),
    'fackgroundColor' => new \Endroid\QrCode\Color\Color(255, 255, 255),
    'labelText' => 'Scan the code',
    'logoPath' => __DIR__.'/../assets/images/getkirby.png',
    'size' => 200,
])->html(
    $page->slug() . '.png'
);
```

## Panel Field: Url of Page/File as QRCode

Add the field to a blueprint. This will show the QRCode as PNG image and will trigger the download of the file on click.

**site/blueprints/default.yml**
```yml
fields:
  # current page
  qrcode: qrcode

  qrcode2:
    type: qrcode
    title: Text below image

  # title with query
  qrcode3:
    type: qrcode
    title: "{{ page.title }}"

  # custom url
  qrcode4:
    type: qrcode
    title: Panel Url of {{ page.title }}
    url: "{{ page.panelUrl }}"

  # custom url and custom filename with |
  qrcode4:
    type: qrcode
    title: Issue 7
    url: "https://github.com/bnomei/kirby3-qrcode/issues/7|Issue 7"
```

You can define the options for the field in your config file. Example:

**site/config/config.php**
```php
<?php

return [
    // other options
    'bnomei.qrcode.field' => [
        'foregroundColor' => new \Endroid\QrCode\Color\Color(126, 154, 191),
        'backgroundColor' => new \Endroid\QrCode\Color\Color(239, 239, 239),
        'size' => 128,
        'margin' => 0,
    ],
];
```

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
