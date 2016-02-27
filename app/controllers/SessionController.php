<?php

use Phalcon\Mvc\Controller;

class SessionController extends Controller
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

    public function authAction(){

    }

    public function removeAction(){
        $this->session->remove("auth");
        header("Location: http://localhost/phalcon_gallery/");
    }

    private function _registerSession($admin)
    {
        $this->session->set(
            'auth',
            array(
                'id'   => $admin->id,
                'name' => $admin->name
            )
        );
    }

    /**
     * Это действие авторизует пользователя в приложении
     */
    public function startAction()
    {
        if ($this->request->isPost()) {

            // Получаем данные от пользователя
            $login    = $this->request->getPost('login');
            $password = $this->request->getPost('password');

            // Производим поиск в базе данных
            $admin = Admins::findFirst(
                array(
                    "name = :name: AND password = :password:",
                    "bind"      => array(
                        'name' => $login,
                        'password' => md5($password)
                    )
                )
            );

            if ($admin != false) {

                $this->_registerSession($admin);

                //$this->flash->success('Welcome ' . $admin->name);
                header("Location: http://localhost/phalcon_gallery/");
                // Перенаправляем на контроллер ..., если пользователь существует
                return ;
            }

        }

        $this->dispatcher->forward(
            array(
                "controller" => "session",
                "action"     => "auth"
            )
        );
        // Снова выдаем форму авторизации
        return ;
    }
}