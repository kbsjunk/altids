<?php namespace Kitbs\Altids\Facades;

use Illuminate\Support\Facades\Facade;

class AltidsFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'altids'; }

}
