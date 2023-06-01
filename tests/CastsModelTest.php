<?php

namespace Devio\ModelCast\Tests;

use Devio\ModelCast\CastsModel;
use Devio\ModelCast\Tests\Support\TabletDeviceModelTest;
use Devio\ModelCast\Tests\Support\PhoneDeviceModelTest;
use Devio\ModelCast\Tests\Support\DeviceModelTest;
use Illuminate\Database\Eloquent\Model;

it('casts a model when retrieving a single record', function () {
    DeviceModelTest::create(['name' => 'phone']);

    $retrievedModel = DeviceModelTest::find(1);
    expect($retrievedModel)->toBeInstanceOf(PhoneDeviceModelTest::class);

    $retrievedModel = DeviceModelTest::where('id', 1)->first();
    expect($retrievedModel)->toBeInstanceOf(PhoneDeviceModelTest::class);
});

it('casts a model when retrieving collections', function () {
    DeviceModelTest::create(['name' => 'phone']);
    DeviceModelTest::create(['name' => 'tablet']);

    $models = DeviceModelTest::all();

    expect($models[0])->toBeInstanceOf(PhoneDeviceModelTest::class)
        ->and($models[1])->toBeInstanceOf(TabletDeviceModelTest::class);
});

it('casts a model when creating', function () {
    $phone = DeviceModelTest::create(['name' => 'phone']);

    expect($phone)->toBeInstanceOf(PhoneDeviceModelTest::class);
});

it('provides the foreign key of the castable class', function () {
    $model = DeviceModelTest::create(['name' => 'phone']);

    expect($model->getForeignKey())->toBe('device_model_test_id');
});

it('should implement Castable interface', function () {
    new class () extends Model {
        use CastsModel;
    };
})->throws(\InvalidArgumentException::class);