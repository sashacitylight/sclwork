<?php
class Db 
{
    const _SERVER_NAME  = "localhost";
    const _USER_NAME    = "root";
    const _PASSWORD     = "";
    const _DATABASE     = "beejeedb";
    
    public static function getConnection() 
    {
        $servername = self::_SERVER_NAME;
        $username   = self::_USER_NAME;
        $password   = self::_PASSWORD;
        $dbName     = self::_DATABASE;
         
        try 
        {  
            # MySQL через PDO_MYSQL  
            $CONNECTION = new PDO( "mysql:host=$servername;dbname=$dbName", $username, $password );
            
            return $CONNECTION;
        }
        catch( PDOException $e ) 
        {  
            echo $e->getMessage();  
        }
    }
}

$CONNECTION = Db::getConnection();



       