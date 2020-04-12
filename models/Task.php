<?php

class Task extends Model
{
    const _numberInOnePage = 3;

    public static function getByID( $id )
    {
        $model = [];

        $query = self::$_CONNECTION->query( "SELECT * from `task` WHERE `task__id` = $id" );
        # устанавливаем режим выборки
        $query->setFetchMode( PDO::FETCH_ASSOC );
        while ( $row = $query->fetch() )
        {
            $model[] = $row;
        }

        return $model;
    }

    public static function getByFilter( $filter = [], $sort = [], $limit = [] )
    {
        $model = [];

        if ( ! empty( $filter ) )
        {
            $filterQuery = "WHERE ";
            if ( ! empty( $filter ) )
            {
                foreach ( $filter as $keyColumn => $valueColumn )
                {
                    $filterQuery .= "`{$keyColumn}` = \"{$valueColumn}\" AND ";
                }
            }
            $filterQuery = trim( $filterQuery, "AND " );
        } else
        {
            $filterQuery = "";
        }

        $limitQuery = "";
        if ( ! empty( $limit ) )
        {
            $limitQuery     = "LIMIT ";
            $limitQuery     .= implode( ", ", $limit );
            $limitQuery     = trim( $limitQuery, ", " );
        }

        $sortQuery = "";
        if ( ! empty( $sort ) )
        {
            $sortFieldNotReal = "";
            if ( $sort[0] )
            {
                $sortField = $sort[0];
                $sortFieldValue = $sort[1];
                if ( ! empty( $sortField ) && ! empty( $sortFieldValue ) )
                {
                    $sortQuery = "ORDER BY `{$sortField}` {$sortFieldValue}";
                }
            }
        } else
        {
            $sortQuery = "ORDER BY `task__id` DESC";
        }

        $query = self::$_CONNECTION->query( "SELECT * from `task` {$filterQuery}  {$sortQuery} {$limitQuery}" );
        # устанавливаем режим выборки
        $query->setFetchMode( PDO::FETCH_ASSOC );
        while ( $row = $query->fetch() )
        {
            $model[] = $row;
        }

        return $model;
    }

    public static function add( $params )
    {
        $model = [];

        $username   = trim( $params["username"] );
        $email      = trim( $params["email"] );
        $text       = trim( $params["text"] );
        $status     = trim( $params["status"] );

        $STH = self::$_CONNECTION->prepare( "INSERT INTO `task` (`task__username`, `task__email`, `task__text`, `task__status`) "
                . "VALUES ('$username', '$email', '$text', '$status');" );
        $STH->execute();

        return self::$_CONNECTION->lastInsertId();
    }

    public static function update( $id, $params )
    {
        $sqlUpdateQuery = " SET ";
        if ( isset( $params["status"] ) )
        {
            $sqlUpdateQuery .= " `task__status` = :task__status ";
        }

        if ( isset( $params["text"] ) )
        {
            $sqlUpdateQuery .= " `task__text` = :task__text ";
        }

        if ( isset( $params["task__adminedited"] ) )
        {
            $sqlUpdateQuery .= " `task__adminedited` = :task__adminedited ";
        }


        if ( isset( $params["status"] ) )
        {
            $query = "UPDATE `task` {$sqlUpdateQuery} WHERE `task__id` = :task__id";
        } 
        elseif ( isset( $params["text"] ) )
        {
            $query = "UPDATE `task` {$sqlUpdateQuery} WHERE `task__id` = :task__id";
        } 
        elseif ( isset( $params["task__adminedited"] ) )
        {
            $query = "UPDATE `task` {$sqlUpdateQuery} WHERE `task__id` = :task__id";
        }

        $executeParams = [
            ':task__id' => $id,
        ];

        if ( isset( $params["status"] ) )
        {
            $executeParams[':task__status'] = $params["status"];
        }

        if ( isset( $params["text"] ) )
        {
            $executeParams[':task__text']   = $params["text"];
        }

        if ( isset( $params["task__adminedited"] ) )
        {
            $executeParams[':task__adminedited'] = $params["task__adminedited"];
        }

        $stmt = self::$_CONNECTION->prepare( $query );
        $stmt->execute( $executeParams );

        return true;
    }

}
