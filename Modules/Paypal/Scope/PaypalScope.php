<?php

/**
 * @package PaypalScope
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 * @created 15-2-22
 */

namespace Modules\Paypal\Scope;

use Illuminate\Database\Eloquent\{Scope, Builder, Model};

class PaypalScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        $builder->where('alias', 'paypal');
    }
}
