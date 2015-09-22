<?php
require 'autoload.php';
$autoload = new AutoLoad();

$config = 'config.php';
if (!file_exists($config)) {
    die(sprintf('Configuration file does not exist "%s"', $config));
}
require $config;
