<?php
const _SITE_URL         = "beejeetest.loc"; 
const _DEBUG_MODE       = "0";
const _MAIN_TEMPLATE    =  'main.php';
define("_ROOT", dirname(__FILE__) );

function dirToArray( $dir ) 
{ 
    if ( file_exists ( $dir ) )
    {
        $result = array(); 
        $cdir   = scandir( $dir ); 
        foreach ( $cdir as $key => $value ) 
        { 
            if ( !in_array( $value, array(".", "..") ) ) 
            { 
               if ( is_dir( $dir . DIRECTORY_SEPARATOR . $value ) ) 
               { 
                  $result[$value] = dirToArray( $dir . DIRECTORY_SEPARATOR . $value ); 
               } 
               else 
               { 
                  $result[] = $value; 
               } 
            } 
        } 

       return $result; 
    }
    
   
} 