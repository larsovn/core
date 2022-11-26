# core
Larso core


## install
```
composer require larso/core
```

## Use
```
// index.php

require 'vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Boot Website
|--------------------------------------------------------------------------
|
| This action will startup all service require for website working
| If missing this is website down
|
*/
Site::bootApp([
	'base'    => __DIR__,
	'storage' => __DIR__.'/storage'
]);
```
