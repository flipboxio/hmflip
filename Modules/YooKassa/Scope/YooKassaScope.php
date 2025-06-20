<?php

/**
 * @package YooKassaScope
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammed Kamrul Hasan <[kamrul.techvill@gmail.com]>
 * @created 18-01-25
 */

namespace Modules\YooKassa\Scope;

use Illuminate\Database\Eloquent\{
    Builder,
    Model,
    Scope
};

class YooKassaScope implements Scope
{

    /**
     * Apply
     *
     * @param Builder $builder
     * @param Model $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('alias', config('yookassa.alias'));
    }
}
