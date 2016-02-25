<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    function initialize(){
        $this->assets
            ->collection('header')
            ->addCss('css/fonts.css')
            ->addCss('css/css/normalize.css')
            ->addCss('css/demo.css')
            ->addCss('css/component.css');

        $this->assets
            ->collection('footer')
            ->addJs('js/classie.js')
            ->addJs('js/dynamics.min.js')
            ->addJs('js/imagesloaded.pkgd.min.js')
            ->addJs('js/main.js');
    }

    function indexAction(){

    }
}