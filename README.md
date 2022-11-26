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

Site::bootApp([
	'base'    => __DIR__,
	'storage' => __DIR__.'/storage'
]);
```
