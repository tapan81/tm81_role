<?php
namespace tapanmandal81\tm81_role;
use Illuminate\Support\ServiceProvider;
//class ContactFormServiceProvider extends ServiceProvider {
class RolePermissionServiceProvider extends ServiceProvider {

	public function boot()
	{
		//echo "Hi";
		// MyVendor\contactform\src\ContactFormServiceProvider.php
    	$this->loadRoutesFrom(__DIR__.'/routes/web.php');
		$this->loadViewsFrom(__DIR__.'/resources/views', 'tm81_role');
		$this->loadMigrationsFrom(__DIR__.'/Database/migrations');
		$this->loadMigrationsFrom(__DIR__.'/Database/seeds');

	}

	public function register()
	{
		//echo "Hi3";
	}
}
?>