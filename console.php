#!/usr/bin/env php
<?php

require __DIR__ . '/bootstrap/start.php';

use Symfony\Component\Console\Application;
use Vortex\Config\Config;

Config::setDirScan( __DIR__ . '/app/config' );


$app = new Application('Vortex', '1.0');

$app->addCommand(new DBExportCommand);
$app->addCommand(new DBExportSchemaCommand);
$app->addCommand(new DBImportCommand);
$app->addCommand(new GenerateControllerCommand);
$app->addCommand(new GenerateCommand);
$app->run();
