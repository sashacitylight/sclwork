<?php

class Router
{

    private $routes; //массив маршрутов

    public function __construct()
    {

        $routesPath = 'routes.php';
        $this->routes = include($routesPath); //присваиваем массив, который хранится в файле routes.php при помощи include()
    }

    private function getURI()
    {
        if ( ! empty( $_SERVER['REQUEST_URI'] ) )
        {
            return trim( $_SERVER['REQUEST_URI'], '/' );
        }
    }

    public function run()
    {
        $uri = $this->getURI();

        if ( empty( $uri ) )
        {
            /* для главной страницы или без урла */
            $internalRoute = 'site/index';
            $segments = explode( '/', $internalRoute );

            $controllerName = array_shift( $segments ) . 'Controller';
            $controllerName = ucfirst( $controllerName );

            $actionName = 'action' . ucfirst( array_shift( $segments ) );

            if ( _DEBUG_MODE == 1 )
            {
                echo "Контроллер : $controllerName";
                echo "Action : $actionName";
            }
            //вытащили контроллер и экшен с массива. Остались только параметры
            //Подключить файл класса-контроллера
            $controllerFile = _ROOT . '/controllers/' . $controllerName . '.php';
            if ( file_exists( $controllerFile ) )
            {
                include_once ( $controllerFile );
            }

            // создать объект, вызвать метод (т.е action)
            $controllerObject = new $controllerName;

            if ( $actionName == 'actionIndexasite' )
            {
                return;
            }

            $result = call_user_func_array( array( $controllerObject, $actionName ), $segments );
        } else
        {
            //если не пустой урл после ссылки /mobile
            $isCompare = false; //не совпадает
            //compare request string, routes from array
            foreach ( $this->routes as $uriPattern => $path )
            {
                if ( preg_match( "~$uriPattern~", $uri ) )
                {
                    $isCompare = true; // один URL совпал
                    //подставляем параметры

                    $internalRoute = preg_replace( "~$uriPattern~", $path, $uri );

                    $segments = explode( '/', $internalRoute );

                    $controllerName = array_shift( $segments ) . 'Controller';
                    $controllerName = ucfirst( $controllerName );

                    $actionName = 'action' . ucfirst( array_shift( $segments ) );

                    //вытащили контроллер и экшен с массива. Остались только параметры
                    //Подключить файл класса-контроллера
                    $controllerFile = _ROOT . '/controllers/' . $controllerName . '.php';

                    /* проверка файла контроллера на существование */
                    $controllerIS = false;
                    if ( file_exists( $controllerFile ) )
                    {
                        include_once ($controllerFile);
                        $controllerIS = true;
                    } else
                    {
                        //нет такого контроллера
                        header( 'location: ' . siteurl );
                        exit();
                    }

                    // создать объект, вызвать метод (т.е action)
                    $controllerObject = new $controllerName;

                    /* получаем массив методов класса */
                    if ( $controllerName == 'NewsController' )
                    {
                        $arrMethods = get_class_methods( $controllerObject );

                        if ( ! in_array( $actionName, $arrMethods ) )
                        {
                            //нет такого экшена
                            header( 'location: ' . siteurl );
                            exit();
                        }
                    }

                    if ( $actionName == 'actionIndexasite' )
                    {
                        return;
                    }

                    $result = call_user_func_array( array( $controllerObject, $actionName ), $segments );

                    if ( $result != null )
                    {
                        break;
                    }
                }
            }

            /* если урл не совпадает ни с одним из прописанных путей */
            if ( ! $isCompare )
            {
                header( 'location:' . siteurl );
                exit;
            }

            //Проверить наличие такого запроса в routes.php
            //Если есть совпадение, определить какой контроллер и action обрабатывают запрос
            //Подключить файл класса-контроллера 
            //Создать объект, вызвать метод (т.е action)
            if ( _DEBUG_MODE == 1 )
            {
                echo "Class Router Method Run";
            }
        }
    }

    public static function ErrorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header( 'HTTP/1.1 404 Not Found' );
        header( "Status: 404 Not Found" );
        header( 'Location:' . $host . '404' );
    }

}
