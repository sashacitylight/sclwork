<?php
class View
{
    public $template_view; // здесь можно указать общий вид по умолчанию.

    /*
      $content_file - виды отображающие контент страниц;
      $template_file - общий для всех страниц шаблон;
      $data - массив, содержащий элементы контента страницы. Обычно заполняется в модели.
     */

    function render( $content_view, $controllerName, $data = null, $actionController = null, $template_view = _MAIN_TEMPLATE )
    {
        if ( empty( $template_view ) )
        {
            $template_view = _MAIN_TEMPLATE;
        }

        $nameController = '';
        $pieces = explode( 'Controller', $controllerName );
        $nameController = strtolower( $pieces[0] );

        if ( isset( $actionController ) && ! empty( $actionController ) )
        {
            $arr = explode( 'action', $actionController );
            $actionController = (string) strtolower( $arr[1] );
        }

        include 'template/layouts/' . $template_view;
    }

    //подгружается страница html при ajax запросе, чтобы не брать шаблон
    function AjaxRender( $content_view, $controllerName, $data = null, $template_view = _MAIN_TEMPLATE )
    {
        $nameController = '';
        $pieces = explode( 'Controller', $controllerName );
        $nameController = strtolower( $pieces[0] );

        include 'views/' . $nameController . '/' . $content_view;
    }

}
