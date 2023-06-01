<?php

namespace Devio\ModelCast;

use Illuminate\Database\Eloquent\Model;

trait CastsModel
{
    public bool $isCastedModel = false;

    public static function bootCastsModel()
    {
        if (!new static instanceof Castable) {
            throw new \InvalidArgumentException('CastsModel trait should implement Castable interface.');
        }
    }

    public function getCastableModelClass(): string
    {
        return self::class;
    }

    public function getCastableModel():self
    {
        return new ($this->getCastableModelClass());
    }

    public function getTable(): string
    {
        if (static::class == $this->getCastableModelClass()) {
            return parent::getTable();
        }

        return $this->getCastableModel()->getTable();
    }

    public function getForeignKey(): string
    {
        if (static::class == $this->getCastableModelClass()) {
            return parent::getForeignKey();
        }

        return $this->getCastableModel()->getForeignKey();
    }

    public function newInstance($attributes = [], $exists = false)
    {
        if (!count($attributes) || $this->isCastedModel) {
            return parent::newInstance($attributes, $exists);
        }

        $class = $this->getCastedModelClass($attributes);
        /** @var $this $model */
        $model = new $class;
        $model->isCastedModel = true;

        return $model->newInstance($attributes, $exists);
    }

    public function newFromBuilder($attributes = [], $connection = null): static
    {
        $attributes = (array)$attributes;

        if (!count($attributes) || $this->isCastedModel) {
            return parent::newFromBuilder($attributes, $connection);
        }

        $class = $this->getCastedModelClass($attributes);
        /** @var Model $instance */
        $instance = new $class;
        $instance->isCastedModel = true;

        return $instance->newFromBuilder($attributes, $connection);
    }
}