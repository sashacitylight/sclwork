<?php header('Content-Type: text/html; charset=utf-8');
error_reporting(0);


session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . '/config.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/components/Router.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/components/Db.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/components/controller.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/components/model.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/components/view.php';

Model::$_CONNECTION = $CONNECTION;

/*подключение всех моделей проекта */
$modelFiles = dirToArray($_SERVER["DOCUMENT_ROOT"] . "/models");
if ( !empty( $modelFiles ) )
{
    foreach ( $modelFiles as $modelFilesOne )
    {
        if ( file_exists( $_SERVER["DOCUMENT_ROOT"] . "/models/{$modelFilesOne}") )
        {
            include_once $_SERVER["DOCUMENT_ROOT"] . "/models/{$modelFilesOne}";
        }
    }
}


//Запускаем Ядро проекта
$router = new Router();
$router->run();
?>