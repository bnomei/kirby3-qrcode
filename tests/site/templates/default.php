<?php

    // base64 encoded png image tag
    echo $page->qrcode()->html(
        $page->slug() . '.png'
    );
