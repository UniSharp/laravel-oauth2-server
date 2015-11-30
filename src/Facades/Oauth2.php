<?php

namespace Unisharp\Oauth2\Facades;

use Illuminate\Support\Facades\Facade;

class Oauth2 extends Facade {

  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  { 
  	return 'oauth2'; 
  }

}