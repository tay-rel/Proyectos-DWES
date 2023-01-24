<?php

namespace App\Providers;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Sortable;
use Illuminate\Database\Eloquent\Builder ;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('shared._card', 'card');
			 $this->app->bind(LengthAwarePaginator::class,
				 \App\LengthAwarePaginator::class);
				
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
			 //Cuando se genera una clase de Sortable enlaza un objeto
        $this -> app ->bind(Sortable::class , function ($app){
					 return new Sortable(request()->url());
					 //Request es la peticion que se guarda lo que viene por get y post .
					 //Entonces el metodo Url nos devuelve la url que tiene en ese momento.
				});
    
		}
}
