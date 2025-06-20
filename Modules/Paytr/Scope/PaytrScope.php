<?php

/**
 * @package Paytr scope
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammed Kamrul Hasan <[kamrul.techvill@gmail.com]>
 * @created 18-09-2024
 */

namespace Modules\Paytr\Scope;

use Illuminate\Database\Eloquent\{
    Builder,
    Model,
    Scope
};

class PaytrScope implements Scope
{

    /**
     * Scope of the paytr
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('alias', 'paytr');
    }
}
