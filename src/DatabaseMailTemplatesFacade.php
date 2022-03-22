<?php

namespace DojoSh\DatabaseMailTemplates;

use Illuminate\Support\Facades\Facade;

class DatabaseMailTemplatesFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'database-mail-templates';
    }
}
