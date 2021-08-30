<?php

@include_once __DIR__ . '/vendor/autoload.php';

Kirby::plugin('bnomei/qrcode', [
    'options' => [
        'field' => [
            /* EXAMPLE:
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
                'image' => function (?string $data = null) {
                    return $this->model()->qrcode(option('bnomei.qrcode.field', []))
                        ->html($this->model()->slug() . '.png');
                },
                'url' => function (?string $data = null) {
                    $id = str_replace(
                        '/',
                        '+S_L_A_S_H+',
                        $this->model()->uri()
                    );
                    
                    return site()->url() . '/plugin-qrcode/' . $id . '/' . \Bnomei\QRCode::hashForApiCall($id);
                },
            ],
        ],
    ],
    'routes' => [
        [
            'pattern' => 'plugin-qrcode/(:any)/(:any)',
            'action' => function (string $id, string $secret) {
                $id = str_replace(
                    '+S_L_A_S_H+',
                    '/',
                    $id
                );
                $hash = \Bnomei\QRCode::hashForApiCall($id);
                if ($hash === $secret && $page = page($id)) {
                    $page->qrcode(option('bnomei.qrcode.field', []))->download(
                        $page->slug() . '.png'
                    );
                }
            }
        ],
    ],
    'pageMethods' => [
        'qrcode' => function (array $options = []) {
            return new \Bnomei\QRCode(array_merge([
                'Text' => $this->url(),
            ], $options));
        },
    ],
    'fileMethods' => [
        'qrcode' => function (array $options = []) {
            return new \Bnomei\QRCode(array_merge([
                'Text' => $this->url(),
            ], $options));
        },
    ],
  ]);
