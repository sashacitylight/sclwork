<?php //

class User extends Model
{

    public static function getTest()
    {
        global $connection, $DBH;
        
        //$sasha = "saha";
        //$STH = $DBH->prepare("INSERT INTO user ( `fio`, `name`, `secondname` ) values ( '$sasha', 'cathy2', 'cathy3' )");  
        //$STH->execute();
        
//        $number = 2;
//        $STH = $DBH->query("SELECT id, fio, name from user WHERE ID = $number");  
//        $STH->setFetchMode(PDO::FETCH_ASSOC);  
//
//        while($row = $STH->fetch()) {  
//            echo $row['id'] . "\n";  
//            echo $row['fio'] . "\n";  
//            echo $row['name'] . "\n";  
//        }
        
        
//        $query = mysqli_query($connection, "SELECT * FROM `user`"  );
//        while ( $row = mysqli_fetch_assoc($query) )
//        {
//            echo "<pre>";
//            print_r($row);
//            echo "</pre>";
//            die('die');
//        }
    } 
    
    
    
    
    public static function getByID($ID)
    {
        $idUser = (int) $ID;
        $model = array();
        $model = mysql_fetch_assoc(mysql_query(
                "SELECT `id_user`, `login`, `password`, `banned`, `rights`, "
                . "`fio`, `mail`, `mobile`, `icq`, `via_mail_c`, `via_icq_c`, `via_sms_c`, `via_mail_k`, `via_icq_k`, "
                . "`via_sms_k`, `via_mail_i`, `via_icq_i`, `via_sms_i`, `lang`, `reg`, `last_entered` "
                . "FROM users WHERE id_user = '" . mysql_real_escape_string($idUser) . "'", NEWS));

        return $model;
    }

    public static function Enter($login, $password)
    {
        $r = mysql_query("SELECT id_user, login, rights FROM users WHERE "
                . "login = '" . mysql_real_escape_string($_POST['login']) . "' AND "
                . "password = '" . mysql_real_escape_string($_POST['password']) . "'", NEWS);
        if (mysql_num_rows($r) == 0)
        {
            return false;
        } else
        {
            $r = mysql_fetch_assoc($r);
        }

        return $r;
    }

    public static function WriteUserToSession($modelUser)
    {
        if (empty($modelUser))
        {
            /* выход */
            $_SESSION['user_num'] = "";
            $_SESSION['user_name'] = "";
            $_SESSION['user_rights'] = "";
        } else
        {
            /* вход */
            $_SESSION['user_num'] = $modelUser['id_user'];
            $_SESSION['user_name'] = $modelUser['login'];
            $_SESSION['user_rights'] = $modelUser['rights'];
            $time = getdate();
            @mysql_query(
                "UPDATE users SET last_entered = '" . mysql_real_escape_string($time['year'])
                . "-" . mysql_real_escape_string($time['mon'])
                . "-" . mysql_real_escape_string($time['mday']) . "' "
                . "WHERE id_user = '" . mysql_real_escape_string($_SESSION['user_num']) . "';", NEWS);
        }
    }

    public static function redirectToCabinetIfIsLogin()
    {
        if (isset($_SESSION['user_num']) && !empty($_SESSION['user_num']))
        {
            header('location: ' . siteurl . 'cabinet');
            exit();
        }
    }

    public static function redirectToLoginIfIsnotLogin()
    {
        if (!(isset($_SESSION['user_num']) && !empty($_SESSION['user_num'])))
        {
            header('location: ' . siteurl . 'enter');
            exit();
        }
    }

}
