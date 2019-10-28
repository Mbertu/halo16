<?php

  namespace halo16;

  interface IFactory{

     public function createController($category, $page, $args = null);

     public function createModel($category, $page, $args = null);

     public function createView($category, $page, $args = null);

  }
