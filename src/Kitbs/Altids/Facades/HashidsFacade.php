<?php namespace Kitbs\Altids\Facades;

use Illuminate\Support\Facades\Facade;

class HashidsFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'hashids'; }

}
