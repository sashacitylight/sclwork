<?php
class UserController extends Controller 
{
    //авторизация 
    public function actionAjaxenter()
    {
        if ( isset( $_POST["enter"] ) && !empty( $_POST["enter"] ) )
        {
           $login       =  trim( $_POST["login"]    );
           $password    =  trim( $_POST["password"] );
           if ( $login == "admin" && $password == "123" )
           {
                $_SESSION["is_admin"]   = true;
                
                $result["result"]       = "success";
                echo json_encode($result);
                exit();
           }
           else
           {
                $_SESSION["is_admin"]   = false;
                
                $result["result"]       = "error";
                echo json_encode($result);
                exit();
           }
        }
        
        $this->view->render('enter.php', get_class() );
        return true;
    }
    
    
    /*авторизация*/
    public function actionAjaxlogout()
    {
        $_SESSION["is_admin"] = false;
        $result["result"] = "success";
        echo json_encode($result);
        
        return true; 
    } 
}
