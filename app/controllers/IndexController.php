<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function initialize(){
        $this->assets
            ->collection('header')
            ->setTargetPath('css/style.min.css')
            ->setTargetUri('css/style.min.css')
            ->addCss('libs/Bootstrap/css/bootstrap.min.css')
            ->join(true)
            ->addFilter(new Phalcon\Assets\Filters\Cssmin());

        $this->assets
            ->collection('footer')
            ->setTargetPath('js/style.min.js')
            ->setTargetUri('js/style.min.js')
            ->addJs('libs/jquery/jquery-1.11.1.min.js')
            ->addJs('libs/Bootstrap/js/bootstrap.min.js')
            ->join(true)
            ->addFilter(new Phalcon\Assets\Filters\Jsmin());
    }

    public function indexAction(){
        $this->view->setVar('images', Images::find());
    }
}
