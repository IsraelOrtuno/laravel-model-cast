<?php

namespace Devio\ModelCast;

class ModelCastResolver
{
    public function resolve(Castable $model, string $parentModelClass, $attributes)
    {
        $class = $model->resolveCastedModel($attributes);

        if (class_exists($class)) {
            return new $class;
        }

        return new $parentModelClass;
    }
}