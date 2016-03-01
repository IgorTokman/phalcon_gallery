<?php

use Phalcon\Mvc\Controller;

class AdminController extends Controller
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
            ->addJs('js/common.js')
            ->join(true)
            ->addFilter(new Phalcon\Assets\Filters\Jsmin());
    }

    public function managementAction(){
        $this->view->setVar('images', Images::find());
    }

    public function deleteAction($id){
        Images::findFirst($id)->delete();
        header("Location: http://localhost/phalcon_gallery/admin/management");
    }

    public function editAction($id){
        $image = Images::findFirst($id);
        $this->view->setVar('image', $image);
}

    public function saveAction(){
        if($this->request->isPost()){
            $title  = $this->request->getPost('title');
            $author = $this->request->getPost('author');
            $url    = $this->request->getPost('url');

            $image = Images::findFirst($this->request->getPost('id'));

            $image->title = $title;
            $image->athor = $author;
            $image->url = $url;

            $image->save();
        }
        header("Location: http://localhost/phalcon_gallery/admin/management");
    }

    public function imagesAction(){

    }

    public function photographersAction(){


    }

    public function citationsAction(){

    }

    public function addAction()
    {
        if ($this->request->isPost()) {
            $title = $this->request->getPost('title');
            $author = $this->request->getPost('author');
            $url = $this->request->getPost('url');

            $image = new Images();
            $image->athor = $author;
            $image->url = $url;
            $image->title = $title;

            if($image->create())
                header("Location: http://localhost/phalcon_gallery/admin/management");
        }
    }
}