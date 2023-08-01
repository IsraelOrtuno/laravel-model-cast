<?php

namespace Devio\ModelCast\Tests;

use Devio\ModelCast\Tests\Support\TabletDeviceModelTest;
use Devio\ModelCast\Tests\Support\PhoneDeviceModelTest;
use Devio\ModelCast\Tests\Support\DeviceModelTest;
use Illuminate\Database\Eloquent\Relations\Relation;

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
    $model = new DeviceModelTest();

    expect($model->getForeignKey())->toBe('device_model_test_id');
});

it('provides the table name of the castable class', function () {
    $model = new PhoneDeviceModelTest();

    expect($model->getTable())->toBe('device_models');
});

it('provides castable model morph class by default', function () {
    $model = new PhoneDeviceModelTest();

    expect($model->getMorphClass())->toBe($model->getCastableModelClass());
});

it('provides casted model morph class when present in morph map', function () {
    Relation::morphMap([
        'tablet' => TabletDeviceModelTest::class
    ]);

    $model = new TabletDeviceModelTest();

    expect($model->getMorphClass())->toBe('tablet');
});

it('forces model casting', function () {
    $m = (new DeviceModelTest(['name' => 'phone']))->forceCast();
    expect($m)->toBeInstanceOf(PhoneDeviceModelTest::class);
});