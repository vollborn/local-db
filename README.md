# LocalDB

LocalDB is a small package to read and write JSON files in a Laravel Eloquent like style.
<br>It was originally developed for small web servers that cannot connect to classic databases.


<br>

## Installation

This package ist available via [composer](https://getcomposer.org/).

```shell
composer require vollborn/local-db
```

<br>


## Configuration

### Set the base path
In the base path all json files are stored. The default value is **../storage/local-db**.

You can change it if you need to:
```php
LocalDB::setBasePath(<your path>);
```


### Register a table

Every table or json file needs to be registered beforehand.

```php
LocalDB::table('test', static function (Table $table) {
    $table->int('int')->autoincrements();
    $table->array('array')->nullable();
    $table->boolean('boolean');
    $table->float('float');
    $table->string('string');
});
```

As you can see, there are multiple data types available:

| Name    | Function |
|---------|----------|
| Integer | int      |
| Array   | array    |
| Boolean | boolean  |
| Float   | float    |
| String  | string   |

In addition, integers can have *autoincrements*.
<br>All data types can also be *nullable*.


<br>

## Usage


### Create data

```php
LocalDB::query('test')->create([
    'float' => 1.00,
    'string' => null,
    'boolean' => false,
    'array' => []
]);
```


### Get data

You can either get all data...
```php
LocalDB::query('test')->get();
```

or just the first entry...
```php
LocalDB::query('test')->first();
```

The data can also be filtered.
```php
LocalDB::query('test')->where('float', '=', 1.00)->get();
```

Available operators:
- =
- !=
- <
- \>
- <=
- \>=

Furthermore, the data can be ordered.
```php
// ascending
LocalDB::query('test')->orderBy('float')->get();

// descending
LocalDB::query('test')->orderBy('float', true)->get();
```

There are some numeric operations available too.
```php
// minimal value
LocalDB::query('test')->min('float');

// maximal value
LocalDB::query('test')->max('float');

// average value
LocalDB::query('test')->avg('float');

// summed value
LocalDB::query('test')->sum('float');
```


### Update data

```php
LocalDB::query('test')
    ->where('boolean', '=', false)
    ->update([
        'boolean' => true
    ]);
```


### Delete data

```php
LocalDB::query('test')
    ->where('boolean', '=', false)
    ->delete();
```
