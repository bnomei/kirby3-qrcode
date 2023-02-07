<?php

const KIRBY_HELPER_DUMP = false;

require '../vendor/autoload.php';
echo (new Kirby())->render();
