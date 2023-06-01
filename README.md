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

You need at least 2 classes for this to work, a *generic* class which will be the base Model class with all common attributes and the specific casted class which will be resolved using those attributes.

Let's use cars in our example. `Car` will be our generic model and `TeslaCar` and `FordCar` the more specific classes the cars will be resolved to.

The base model should just use the `CastsModel` trait and implement the `getCastedModelClass` method which will be responsible of resolving which class should be this model be casted to based on its attributes data.

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

class TeslaCar extends Car {}
class FordCar extends Car {}


```

That's all to do. The underlying logic will be casting our `Car` instances to `TeslaCar` or `FordCar` when retrieving models:

```php
$instance = Car::find(1); 
$instance::class; // -> TeslaCar
```

It will also work right when creating a model using the `create` method:

```php
$instance = Car::create(['brand' => 'tesla']);
$instance::class; // -> TeslaCar
```

Eloquent collections will be casted too:

```php
$collection = Car::all();
$collection[0]::class; // -> TeslaCar
$collection[1]::class; // -> FordCar
```
