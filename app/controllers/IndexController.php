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
            ->addCss('libs/fancybox/jquery.fancybox-1.3.4.css')
            ->join(true)
            ->addFilter(new Phalcon\Assets\Filters\Cssmin());

        $this->assets
            ->collection('footer')
            ->setTargetPath('js/style.min.js')
            ->setTargetUri('js/style.min.js')
            ->addJs('libs/jquery/jquery-1.11.1.min.js')
            ->addJs('libs/Bootstrap/js/bootstrap.min.js')
            ->addJs('libs/fancybox/jquery.mousewheel-3.0.4.pack.js')
            ->addJs('libs/fancybox/jquery.fancybox-1.3.4.pack.js')
            ->join(true)
            ->addFilter(new Phalcon\Assets\Filters\Jsmin());
    }

    public function indexAction(){
        $images = Images::find();
        $this->view->setVar('images', $images);
    }
}
