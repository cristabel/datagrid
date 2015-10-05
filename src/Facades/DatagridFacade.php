<?php namespace Cristabel\Datagrid\Facades;

use Illuminate\Support\Facades\Facade;

class DatagridFacade extends Facade {

    protected static function getFacadeAccessor() 
    {
		return 'datagrid';
	}

}
