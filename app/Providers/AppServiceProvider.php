<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Session;

class AppServiceProvider extends ServiceProvider {
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
      public function boot(Request $request) {
		if(!isset($_COOKIE["in_mobile"])){
			$detect = getsystemInfo($_SERVER);
			if($detect['device']=='MOBILE') {
				$_COOKIE['in_mobile'] = '1';
			}
			else {
				$_COOKIE['in_mobile'] = '0';
			}
		}
		Schema::defaultStringLength(191);
		app('view')->composer(['home','amp.home','layouts.admin.partials.sidebar','layouts.partials.top-nav','layouts.partials.footer_scripts','layouts.partials.header','layouts.Masters.Master','users.sidebar','amp.layouts.admin.partials.sidebar','amp.layouts.partials.top-nav','amp.layouts.partials.footer_scripts','amp.layouts.partials.header','amp.layouts.Masters.Master','amp.users.sidebar','layouts.partials.footer'], function ($view) {
			$action = "";
			$controller = "";
			if(app('request')->route()) {
				$action = app('request')->route()->getAction();
				$controller = class_basename($action['controller']);
				list($controller, $action) = explode('@', $controller);
				$view->with(compact('controller', 'action'));
			}
			else{
				$view->with(compact('controller', 'action'));
			}
		});
		Paginator::useBootstrap();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
