<?php namespace Miladr\Jalali;

use Illuminate\Support\ServiceProvider;

class JalaliServiceProvider extends ServiceProvider {

	 /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = false;
 
  /**
   * Bootstrap the application events.
   *
   * @return void
   */
  public function boot()
  {
    $this->package('miladr/jalali');
  }
 
  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
      $this->app['jalali'] = $this->app->share(function($app)
  		{
  		  return new jDate;
  		});


  }
 
  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return array('jalali');
  }

}