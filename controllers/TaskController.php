<?php
class TaskController extends Controller 
{
    /*авторизация*/
    public function actionAjaxaddtask()
    {
        $username = trim( $_REQUEST["username"] ); 
        $email    = trim( $_REQUEST["email"] ) ; 
        $text     = trim( $_REQUEST["text"] ) ; 
        $status   = trim( $_REQUEST["status"] ); 
        
        $validate = true;
        if ( empty( $username ) || empty( $email ) || empty( $text ) )
        {
            $validate = false; 
        }
        elseif ( !filter_var( $email, FILTER_VALIDATE_EMAIL) ) 
        {
            $validate = false; 
        }
        else
        {
            $data["username"]   = $username;
            $data["email"]      = $email;
            $data["text"]       = $text;
            $data["status"]     = $status;
            
            $lastInsertId = Task::add( $data );
        }
        
        if ( $lastInsertId )
        {
            $result = array('result' => 'success');
        }
        else
        {
            $result = array('result' => 'error');
        }
        
        echo json_encode( $result );
        exit;
        
        return true; 
    } 
    
    public function actionAjaxupdatestatus()
    {
        if ( ! ( isset( $_SESSION["is_admin"] ) && !empty( $_SESSION["is_admin"] ) )  )
        {
            $result = array('result' => 'notauthorized');
            echo json_encode( $result );
            exit;
        }
        
        $taskId    = trim( $_REQUEST["taskId"] ); 
        $status    = trim( $_REQUEST["status"] ) ; 
        
        if ( empty( $taskId )  )
        {
            exit;
        }
       
        $data["status"] = $status;
        Task::update( $taskId, $data );
        
        $result = array('result' => 'success');
        
        echo json_encode( $result );
        exit;
        
        return true; 
    } 
    
    
    public function actionAjaxupdatetext()
    {
        if ( ! ( isset( $_SESSION["is_admin"] ) && !empty( $_SESSION["is_admin"] ) )  )
        {
            $result = array('result' => 'notauthorized');
            echo json_encode( $result );
            exit;
        }
        
        $taskId     = trim( $_POST["task-id"] ); 
        $text       = trim( $_POST["text"] ) ; 
        
        if ( empty( $taskId )  )
        {
            exit;
        }
       
        $data["text"] = $text;
        Task::update( $taskId, $data );
        
        $data = [];
        $data["task__adminedited"] = "1";
        Task::update( $taskId, $data );
        
        $result = array('result' => 'success');
        
        echo json_encode( $result );
        exit;
        
        return true; 
    }
    
    
    
    public function actionGettask()
    {
        if ( !empty( $_REQUEST["taskId"] ) )
        {
            $taskId = $_REQUEST["taskId"];
        }
        $modelTask = Task::getByFilter( [ "task__id" => $taskId  ] )[0];
        ob_start();
        ?>
            <input type="hidden" name="task-id" value="<?=$modelTask["task__id"]?>">

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Текст задачи</label>
                <textarea name="text" class="form-control" 
                    id="exampleFormControlTextarea1" rows="3" required><?=$modelTask["task__text"]?></textarea>
                <div class="valid-feedback">
                    Успешно заполнено!
                </div>
                <div class="invalid-feedback">Не заполнено! </div>
            </div>

            <button id="btnEditTask" type="button" class="btn btn-primary"><i class="far fa-save"></i> Обновить </button>
        <?php
        $text = ob_get_contents();
        ob_end_clean();
        echo $text;
        exit();
        return true;
    }
}
