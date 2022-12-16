# core

Larso core

## install

```
composer require larso/core
```

## Use

```
// index.php

use Larso\Foundation\Site;

require 'vendor/autoload.php';

Site::bootApp(__DIR__);
```

### DB info connect

```
Site::setDatabase([
 'username' => 'root',
 'password' => '',
 'database' => 'db'
]);
```

## Supported

almost Laravel
