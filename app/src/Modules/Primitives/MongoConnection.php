<?php

namespace App\Modules\Primitives;

abstract class MongoConnection{

  protected $mongo;
  protected $collection;

  public abstract function __construct($mongo);

}

?>