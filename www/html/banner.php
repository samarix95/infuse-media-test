<?php

require_once('./App/Autoloader.php');

use App\CollectData;

App\Autoloader::register();
CollectData::process();

echo './picture.png';
