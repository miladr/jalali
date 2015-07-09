<?php namespace Morilog\Jalali\Facades;
 
use Illuminate\Support\Facades\Facade;
 
class JDateTime extends Facade {
 
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor() { return 'jDateTime'; }
 
}
