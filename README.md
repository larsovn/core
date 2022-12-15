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

## Supported

- Database (Eloquent)

```
DB::table('table')->get();
```

- View (Blade)

```
View::make('view-path', $data);
```

- Request

```
Request::all();
```

- Filesystem

```
File::allFiles('dir-path')
```

- Cache

```
Cache::put('key', 'value');
```

- Session

```
Session::all()
```

- Validation

```
$validate = Validator::make($request->all(), [
 'name' => 'required|min:3',
 'age'  => 'required|numeric'
], [
 'name.required' => ':attribute not null',
 'name.min'      => ':attribute short',
 'age.numeric'   => ':attribute is number'
]);

dd(
 $validate->errors()->all(),
 $validate->fails(),
);
```
