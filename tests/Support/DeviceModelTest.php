<?php

namespace Devio\ModelCast\Tests\Support;

use Devio\ModelCast\CastsModel;
use Illuminate\Database\Eloquent\Model;

class DeviceModelTest extends Model
{
    use CastsModel;

    protected $table = 'device_models';

    protected $guarded = [];

    public $timestamps = false;

    public function getCastedModelClass(array $attributes): string|null
    {
        if ($attributes['name'] == 'phone') return PhoneDeviceModelTest::class;
        if ($attributes['name'] == 'tablet') return TabletDeviceModelTest::class;

        return null;
    }
}