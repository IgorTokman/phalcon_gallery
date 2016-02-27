<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Session\Adapter\Files as Session;

try {

    // Регистрируем автозагрузчик
    $loader = new Loader();
    $loader->registerDirs(array(
        '../app/controllers/',
        '../app/models/'
    ))->register();

    // Создаем DI
    $di = new FactoryDefault();

    $di->set('db', function () {
        return new DbAdapter(array(
            "host"     => "localhost",
            "username" => "root",
            "password" => "",
            "dbname"   => "gallery"
        ));
    });

    // Начинаем сессию при первом запросе сервиса каким-либо компонентом
    $di->setShared('session', function () {
        $session = new Session();
        $session->start();
        return $session;
    });
    // Настраиваем компонент View
    $di->set('view', function () {
        $view = new View();
        $view->setViewsDir('../app/views/');
        return $view;
    });

    $di->set('dispatcher', function () {
        // Создание менеджера событий
        $eventsManager = new EventsManager();
        // Прикрепление функции-слушателя для событий типа "dispatch"
        $eventsManager->attach("dispatch", function ($event, $dispatcher) {
            // ...
        });
        $dispatcher = new MvcDispatcher();
        // Связывание менеджера событий с диспетчером
        $dispatcher->setEventsManager($eventsManager);
        return $dispatcher;
    }, true);

    // Настраиваем базовый URI так, чтобы все генерируемые URI содержали директорию "phalcon_gallery"
    $di->set('url', function () {
        $url = new UrlProvider();
        $url->setBaseUri('/phalcon_gallery/');
        return $url;
    });

    // Обрабатываем запрос
    $application = new Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo "Exception: ", $e->getMessage();
}