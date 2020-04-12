<?php
class SiteController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function actionIndex( $currentPage = 1, $sortField = "", $sortFieldValue = "", $sortClick = 0 )
    {
        $numrows = count( Task::getByFilter() );
        // количество страниц
        // какое количество страниц от текущей показывать в пагинации
        $range          = 3;
        // какое количество записей показывать на одной странице
        $rowsperpage    = 3;
        $totalpages     = ceil( $numrows / $rowsperpage );
        // получить текущую страницу или установить её по умолчанию
        if ( isset( $currentPage ) && is_numeric( $currentPage ) )
        {
            // текущая страница из GET
            $currentpage = (int) $currentPage;
        } else
        {
            // текущая страница по умолчанию
            $currentpage = 1;
        }
        // если номер текущей страницы больше числа страниц...
        if ( $currentpage > $totalpages )
        {
            // установить текущую страницу равной последней
            $currentpage = $totalpages;
        }
        // если номер страницы меньше чем номер первой страницы...
        if ( $currentpage < 1 )
        {
            // установить текущую страницу равной первой
            $currentpage = 1;
        } 
        
        // смещение списка, основанного на значения номера текущей страницы 
        $offset = ($currentpage - 1) * $rowsperpage;

        switch ( $sortField )
        {
            case "username" : $sortFieldInSql   = "task__username";
                break;
            case "email"    : $sortFieldInSql      = "task__email";
                break;
            case "status"   : $sortFieldInSql     = "task__status";
                break;
            default : $sortFieldInSql = "";
        }

        $arraySort = [];
        if ( ! empty( $sortClick ) && ! empty( $sortFieldValue ) )
        {
            if ( $sortFieldValue == "ASC" )
            {
                $sortFieldValue = "DESC";
            } 
            elseif ( $sortFieldValue == "DESC" )
            {
                $sortFieldValue = "ASC";
            }
        } 
        elseif ( empty( $sortFieldValue ) )
        {
            $sortFieldValue = "ASC";
        }

        if ( ! empty( $sortFieldInSql ) )
        {
            $arraySort = [ $sortFieldInSql, $sortFieldValue ];
        }

        $modelTasks = Task::getByFilter( [], $arraySort, [ $offset, $rowsperpage ] );

        $data["currentpage"]    = $currentpage;
        $data["range"]          = $range;
        $data["totalpages"]     = $totalpages;
        $data['modelTasks']     = $modelTasks;
        $data["sortField"]      = $sortField;
        $data["sortFieldValue"] = $sortFieldValue;

        $this->view->render( 'index.php', get_class(), $data );
        return true;
    }

}
