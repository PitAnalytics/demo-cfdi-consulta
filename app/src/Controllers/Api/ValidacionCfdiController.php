<?php

namespace App\Controllers\Api;

use App\Controllers\Primitives\Controller as Controller;
use Psr\Container\ContainerInterface as Container;

class ValidacionCfdiController extends Controller{
  
  //
  public function __construct(Container $container){

    //
    $this->container=$container;
    $this->setMainInstances();
    $this->setSoapInstances();
    $this->setDatabaseInstances();
    $this->setViewInstances();
    $this->setModuleInstances();

  }
  //
  protected function setMainInstances(){

    //
    $this->config=$this->container['config'];
    $this->globals=$this->config->globals();

  }
  //
  protected function setSoapInstances(){

    //
    $this->soap['validacion-cfdi']=$this->container['validacion-cfdi'];

  }
  //
  protected function setDatabaseInstances(){

    $this->mongo=$this->container['mongo-db'];

  }
  //
  protected function setViewInstances(){

    $this->views=$this->container['dynamic-views'];

  }
  //
  protected function setModuleInstances(){
    
    $this->modules['facturas']=$this->container['facturas']($this->mongo);

  }
  public function index($request,$response){
    //
    $facturas=$this->modules['facturas']->index();

    
    $viewData['facturas']=json_decode(json_encode($facturas),true);
    //

    $this->views->render($response,'Layout/index.php',$viewData);
    
  }
  //
  public function update($request,$response){
    //tomamos todas las facturas
    $facturas=$this->modules['facturas']->index();
    //validamos factura por factura
    foreach ($facturas as $factura) {
      $status=$this->soap['validacion-cfdi']->validar($factura->rfcEmisor,$factura->rfcReceptor,$factura->uuid,$factura->total);
      $this->modules['facturas']->updateStatus($factura->uuid,$status);
      unset($factura);
    }

    return $response->withRedirect($this->globals['url']);

  }
  //
  public function reset($request,$response){
    //tomamos todas las facturas
    $facturas=$this->modules['facturas']->index();
    //validamos factura por factura
    foreach ($facturas as $factura) {
      $this->modules['facturas']->updateStatus($factura->uuid,-1);
      unset($factura);
    }
    //
    return $response->withRedirect($this->globals['url']);

  }

}


?>