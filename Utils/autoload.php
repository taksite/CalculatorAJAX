<?php

declare(strict_types=1);

### ---------------------------------------------------------------------
spl_autoload_register(function (string $classNamespace) {
    $path = str_replace(['\\', 'Api/'], ['/', ''], $classNamespace);
    $path = "src/$path.php";
    require_once($path);
  });