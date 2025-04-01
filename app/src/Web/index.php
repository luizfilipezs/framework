<?php

use Luizfilipezs\Application\AppModule;
use Luizfilipezs\Framework\App;

$app = App::fromModule(AppModule::class);

$app->httpsOnly = false;
$app->run();
