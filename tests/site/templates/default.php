<?php

    // base64 encoded png image tag
    echo $page->qrcode()->html(
        $page->slug() . '.png'
    );


    $file = $page->qrcode([
        'Text' => 'Hello',
    ])->save('hello.png', force: true);
    echo $file;
