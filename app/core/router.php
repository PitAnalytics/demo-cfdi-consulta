<?php
  $app->get('/', \App\Controllers\Api\ValidacionCfdiController::class.':index');
  $app->get('/validate', \App\Controllers\Api\ValidacionCfdiController::class.':update');
  $app->get('/reset', \App\Controllers\Api\ValidacionCfdiController::class.':reset');
?>