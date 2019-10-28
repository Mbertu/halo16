<?php

  namespace halo16;

  abstract class AbstractFrontendController extends AbstractController{

    protected function init($args){
        $this->setProperty('model', isset($args['model']) ? $args['model'] : null);
        $this->setProperty('view', isset($args['view']) ? $args['view'] : null);
        $this->setProperty('plugin_url', isset($args['plugin_url']) ? $args['plugin_url'] : null);
    }

    public abstract function renderView();

    public abstract function enqueueCss();

    public abstract function enqueueJs();

  }
