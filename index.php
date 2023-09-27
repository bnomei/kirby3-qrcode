<?php

@include_once __DIR__ . '/vendor/autoload.php';

use Kirby\Cms\App as Kirby;

Kirby::plugin('bnomei/qrcode', [
    'options' => [
        'field' => [
            /* EXAMPLE
            'foregroundColor' => new \Endroid\QrCode\Color\Color(126, 154, 191),
            'backgroundColor' => new \Endroid\QrCode\Color\Color(239, 239, 239),
            'size' => 128,
            'margin' => 0,
            */
        ],
    ],
    'fields' => [
        'qrcode' => [
            'props' => [
                'title' => function (?string $title = null) {
                    return \Bnomei\QRCode::query($title, $this->model());
                },
                'url' => function (?string $url = null) {
                    $slug = null;
                    if (!$url) {
                        $model = $this->model();
                        if ($model instanceof \Kirby\Cms\Site) {
                            $url = "$";
                            $slug = \Kirby\Toolkit\Str::slug(site()->title());
                        } elseif ($model instanceof \Kirby\Cms\File) {
                            $url = $model->id();
                        } else {
                            $url = $model->uri(); // page object
                        }
                    } else {
                        $url = \Bnomei\QRCode::query($url, $this->model());
                    }

                    if (strpos($url, "|") !== false) {
                        list($url, $slug) = explode("|", $url);
                    }

                    if (Str::startsWith($url, "#")) {
                        $ingredientKey = Str::replace($url, '#', '');
                        $url = kirby()->urls()->$ingredientKey;
                    }

                    if ($page = page($url)) {
                        $url = $page->url();
                        if (empty($slug)) {
                            $slug = $page->slug();
                        }
                    }

                    if ($file = site()->file($url)) {
                        $url = $file->url();
                        if (empty($slug)) {
                            $slug = $file->id();
                        }
                    }

                    if (empty($slug)) {
                        $slug = $url;
                    }
                    $slug = \Bnomei\QRCode::query($slug, $this->model());
                    $slug = \Kirby\Toolkit\Str::slug($slug);

                    $hash = \Bnomei\QRCode::hashForApiCall($url);
                    $options = array_merge(
                        ['Text' => ($url === '$' ? site()->url() : $url),],
                        option('bnomei.qrcode.field', [])
                    );
                    $image = $this->model()
                        ->qrcode($options)
                        ->html($slug . '.png');
                    $url = str_replace('/', '+S_L_A_S_H+', $url);

                    $api = implode('/', [
                        kirby()->url(),
                        'plugin-qrcode',
                        urlencode(trim($url, '/')),
                        $slug,
                        $hash
                    ]);

                    return '<a href="' . $api . '" download>' . $image . '</a>';
                },
            ],
        ],
    ],
    'routes' => [
        [
            'pattern' => 'plugin-qrcode/(:any)/(:any)/(:any)',
            'action' => function (string $url, string $slug, string $secret) {
                $url = str_replace('+S_L_A_S_H+', '/', urldecode($url));
                $hash = \Bnomei\QRCode::hashForApiCall($url);
                if ($hash !== $secret) {
                    return;
                }
                if ($url == '$') {
                    site()->qrcode(option('bnomei.qrcode.field', []))->download(
                        \Kirby\Toolkit\Str::slug(site()->title()) . '.png'
                    );
                } elseif ($page = page($url)) {
                    $page->qrcode(option('bnomei.qrcode.field', []))->download(
                        $slug . '.png'
                    );
                } elseif ($file = site()->file($slug)) {
                    $file->qrcode(option('bnomei.qrcode.field', []))->download(
                        Str::slug($file->filename()) . '.png'
                    );
                } else {
                    $options = array_merge(
                        ['Text' => $url,],
                        option('bnomei.qrcode.field', [])
                    );
                    site()->qrcode($options)->download(
                        $slug . '.png'
                    );
                }
                die;
            }
        ],
    ],
    'siteMethods' => [
        'qrcode' => function (array $options = []) {
            return new \Bnomei\QRCode(array_merge([
                'Text' => site()->url(),
            ], $options), $this);
        },
    ],
    'pageMethods' => [
        'qrcode' => function (array $options = []) {
            return new \Bnomei\QRCode(array_merge([
                'Text' => $this->url(),
            ], $options), $this);
        },
    ],
    'fileMethods' => [
        'qrcode' => function (array $options = []) {
            return new \Bnomei\QRCode(array_merge([
                'Text' => $this->url(),
            ], $options), $this);
        },
    ],
    'userMethods' => [
        'qrcode' => function (array $options = []) {
            return new \Bnomei\QRCode(array_merge([
                'Text' => $this->url(),
            ], $options), $this);
        },
    ],
  ]);
