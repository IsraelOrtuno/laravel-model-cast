# Cast Eloquent Model Instances

This package allows you to cast entire Eloquent models. Just like Eloquent's built-in feature for casting attributes but for Model instances.

Cast a base Eloquent model into class model which will share all its attributes but may have a different configuration or relationships. The casting occurs automatically when fetching from database. Here is a very basic example of how this may work:

```php
class Car extends Model implements Castable
{
  use CastsModel;
  // ...
}

class TeslaCar extends Car 
{
}

$instance = Car::find(1);

$instance::class; // -> TeslaCar
```

## Installation

```shell
composer require devio/laravel-model-cast
```


## Usage

```php
class Car extends Model implements Castable 
{
  use CastsModel;
  
  public function getCastedModelClass(array $attributes): string|null 
  {
    // Add your custom resolution logic here based on the model attributes
    if ($attributes['brand'] == 'tesla') return TeslaCar::class;
    if ($attributes['brand'] == 'ford') return FordCar::class;
    
    return null;
  }
}

class TeslaCar extends Car {
}

$instance = Car::find(1); 
$instance::class; // -> TeslaCar

$instance = Car::create(['brand' => 'tesla', ...]);
$instance::class; // -> TeslaCar

$collection = Car::all();
$collection[0]::class; // -> TeslaCar
$collection[1]::class; // -> FordCar
```
