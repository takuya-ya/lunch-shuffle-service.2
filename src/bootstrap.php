<?php

require 'core/AutoLoader.php';

$loader = new AutoLoader();
$loader->registerDir(__Dir__ . '/core');
$loader->registerDir(__Dir__ . '/controller');
$loader->registerDir(__Dir__ . '/models');
$loader->register();
