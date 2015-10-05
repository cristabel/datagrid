<?php namespace Cristabel\Datagrid\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class DatagridServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->registerDatagrid();        
    }
    
    public function boot()
    {
    }
    
    protected function registerDatagrid()
    {
        $this->app->bind(
            'datagrid',
            function () {
                return new \Cristabel\Datagrid\Datagrid;
            }
        );

        AliasLoader::getInstance()->alias('Datagrid', 'Cristabel\Datagrid\Facades\DatagridFacade');
    }
}
