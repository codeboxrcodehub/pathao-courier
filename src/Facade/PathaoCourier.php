<?php

namespace Codeboxr\PathaoCourier\Facade;

use Illuminate\Support\Facades\Facade;
use Codeboxr\PathaoCourier\Manage\Manage;

/**
 * @method static mixed area()
 * @method static mixed store()
 * @method static mixed order()
 * @see Manage
 */
class PathaoCourier extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'pathaocourier';
    }
}
