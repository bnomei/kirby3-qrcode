<?php

@include_once __DIR__ . '/vendor/autoload.php';

Kirby::plugin('bnomei/qrcode', [
    'options' => [
    ],
    'pageMethods' => [
        'qrcode' => function (array $options = []) {
            return new \Bnomei\QRCode(array_merge([
                'Text' => $this->url(),
            ], $options));
        },
    ],
  ]);
