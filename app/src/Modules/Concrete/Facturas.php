<?php

namespace App\Modules\Concrete;

use App\Modules\Primitives\MongoConnection as Connection;

class Facturas extends Connection{

  public function __construct($mongo){

    $this->mongo=$mongo;

    $this->collection = $this->mongo->fiscal->facturas;

  }
  //
  public function index(){

    $cursor = $this->collection->find([],[]);
    //
    $result=[];
    //
    foreach ($cursor as $line) {

      $result[]=$line;

    }
    //
    return $result;

  }
  //

  public function updateStatus(string $uuid,$status){

    //
    $filter=['uuid'=>$uuid];
    $updateData=['$set'=>['status'=>$status]];
    $this->collection->updateOne($filter,$updateData);

  }

  public function fecha(){

    //
    $cursor=$this->collection->distinct('fecha',[],[]);
    $result=[];

    foreach ($cursor as $line) {

      $result[]=$line;

    }
    //
    return $result;

  }
  //
  public function rfcEmisor(){

    //
    $cursor=$this->collection->distinct('rfcEmisor',[],[]);
    $result=[];
    //
    foreach ($cursor as $line) {

      $result[]=$line;

    }
    //
    return $result;

  }

}

?>