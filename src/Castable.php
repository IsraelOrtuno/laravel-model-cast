<?php

namespace Devio\ModelCast;

interface Castable
{
//    public function getCastableBaseModel(): string;
    public function getCastedModelClass(array $attributes): string|null;
}