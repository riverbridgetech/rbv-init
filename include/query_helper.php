<?php
    //updated by punit 16072020 for prevention
    function insert($table, $variables = array() )
    {
        //Make sure the array isn't empty
        global $db_con;

        if( empty( $variables ) )
        {
            return false;
            exit;
        }
        
        $sql = "INSERT INTO ". $table;
        $fields = array();
        $values = array();
        foreach( $variables as $field => $value )
        {
            $fields[] = $field;
            // $values[] = "'".$value."'";
            $values[] = '?';
        }
        $fields = ' (' . implode(', ', $fields) . ')';
        $values = '('. implode(', ', $values) .')';
        
        $sql .= $fields .' VALUES '. $values;
        
        $stmt_insert = $db_con->prepare($sql);
        
        $params = array();
        $tmp = array();
        
        foreach($variables as $field => $value )
        {   
            if(isset($params[0]))
            {
                $params[0] .= 's';
            }
            else
            {
                $params[0] = 's';
            }
            array_push($params, $value);
        }

        foreach($params as $key => $value) 
        $tmp[$key] = &$params[$key];
        
        call_user_func_array(array($stmt_insert, 'bind_param'), $tmp);

        // Attempt to execute the prepared statement
        if($stmt_insert->execute()){
            return $db_con->insert_id;
            // quit($db_con->insert_id);
        } else{
            return false;
            // quit("ERROR: Could not execute query:".$mysqli->error);
            
        }
    }
        
    function quit($msg,$Success="")
    {
        if($Success ==1)
        {
            $Success="Success";
        }
        else
        {
            $Success="fail";
        }
        echo json_encode(array("Success"=>$Success,"resp"=>$msg));
        exit();
    }

    //updated by punit 16072020 for prevention
    // return $row 
    function check_exist($table,$where,$not_where_array=array(),$and_like_array=array(),$or_like_array=array())
    {
            
        global $db_con;
    
        $sql =" SELECT * FROM ".$table." ";
        $sql .=" WHERE 1 = 1 ";
        
        //==Check Where Condtions=====//
        if(!empty($where))
        {
            
            foreach($where as $field1 => $value1 )
            {   
                $sql  .= " AND ".$field1 ."= ? ";
            }
        }
        
        //==Check Not Equal Condtions=====//
        if(!empty($not_where_array))
        {
            
            foreach($not_where_array as $field2 => $value2 )
            {   
                $sql  .= " AND ".$field2 ."!= ? ";
            }
        }
        
        //==Check AND Like Condtions=====//
        if(!empty($and_like_array))
        {
            
            foreach($and_like_array as $field3 => $value3 )
            {   
                $sql  .= " AND ".$field3 ." like ? ";
            }
        }
        
        //==Check AND Like Condtions=====//
        if(!empty($or_like_array))
        {
            
            foreach($or_like_array as $field4 => $value4 )
            {   
                $sql  .= " AND ".$field4 ." like '".$value4."' ";
            }
        }
        
        
        $stmt_chexist = $db_con->prepare($sql);
        
        
        //==Check Where Condtions=====//
        if(!empty($where))
        {
            $params = array();
            foreach($where as $field1 => $value1 )
            {   
                if(isset($params[0]))
                {
                    $params[0] .= 's';
                }
                else
                {
                    $params[0] = 's';
                }
                array_push($params, $value1);
            }
            
            
            foreach($params as $key => $value) 
            $tmp[$key] = &$params[$key];

            call_user_func_array(array($stmt_chexist, 'bind_param'), $tmp);
        }
        
        //==Check Not Equal Condtions=====//
        if(!empty($not_where_array))
        {
            $params = array();
            foreach($not_where_array as $field2 => $value2 )
            {   
                if(isset($params[0]))
                {
                    $params[0] .= 's';
                }
                else
                {
                    $params[0] = 's';
                }
                array_push($params, $value2);
            }
            
            
            foreach($params as $key => $value) 
            $tmp[$key] = &$params[$key];

            call_user_func_array(array($stmt_chexist, 'bind_param'), $tmp);
        }
        
        //==Check AND Like Condtions=====//
        if(!empty($and_like_array))
        {
            $params = array();
            foreach($and_like_array as $field3 => $value3 )
            {   
                if(isset($params[0]))
                {
                    $params[0] .= 's';
                }
                else
                {
                    $params[0] = 's';
                }
                array_push($params, $value3);
            }
            
            
            foreach($params as $key => $value) 
            $tmp[$key] = &$params[$key];

            call_user_func_array(array($stmt_chexist, 'bind_param'), $tmp);
        }
        
        //==Check AND Like Condtions=====//
        if(!empty($or_like_array))
        {
            $params = array();
            foreach($or_like_array as $field4 => $value4 )
            {   
                if(isset($params[0]))
                {
                    $params[0] .= 's';
                }
                else
                {
                    $params[0] = 's';
                }
                array_push($params, $value4);
            }
            
            
            foreach($params as $key => $value) 
            $tmp[$key] = &$params[$key];

            call_user_func_array(array($stmt_chexist, 'bind_param'), $tmp);
        }
        
        $stmt_chexist->execute();
        $result = $stmt_chexist->get_result();
        $nums = $result->num_rows;
        
        
        if($nums == 0)
        {
            return false;
        }
        else
        {
            $row = $result->fetch_array();
            $stmt_chexist->close();
            // return $row['id'];
            return $row;
        }
    }

    //updated by punit 23072020 for prevention
    // return result
    function lookup_value($table,$col_array=array(),$where=array(),$not_where_array=array(),$and_like_array=array(),$or_like_array=array(),$order_by=array())
    {
        global $db_con;
        $colums  =implode(',',$col_array);
        $col     =1;
        if($colums=="")
        {
            $colums =' * ';
            $col    ="";
        }
        $sql =" SELECT ".$colums." FROM ".$table." ";
        $sql .=" WHERE 1 = 1 ";
        //==Check Where Condtions=====//
        if(!empty($where))
        {
            foreach($where as $field1 => $value1 )
            {   
                $sql  .= " AND ".$field1 ."= ? ";
            }
        }
        
        //==Check Not Equal Condtions=====//
        if(!empty($not_where_array))
        {
            foreach($not_where_array as $field2 => $value2 )
            {   
                $sql  .= " AND ".$field2 ."!= ? ";
            }
        }
        
        //==Check AND Like Condtions=====//
        if(!empty($and_like_array))
        {
            foreach($like_array as $field3 => $value3 )
            {   
                $sql  .= " AND ".$field3 ." like ? ";
            }
        }
        //==Check AND Like Condtions=====//
        if(!empty($or_like_array))
        {
            foreach($or_like_array as $field4 => $value4 )
            {   
                $sql  .= " AND ".$field4 ." like ? ";
            }
        }

        if(!empty($order_by))
        {
            $orderByCols = implode(',', $order_by);
            $sql .= " ORDER BY ".$orderByCols;
        }

        // 	return $sql;
    
        $stmt_lookup = $db_con->prepare($sql);
        
        //==Check Where Condtions=====//
        if(!empty($where))
        {
            $params = array();
            foreach($where as $field1 => $value1 )
            {   
                if(isset($params[0]))
                {
                    $params[0] .= 's';
                }
                else
                {
                    $params[0] = 's';
                }
                array_push($params, $value1);
            }
            
            
            foreach($params as $key => $value) 
            $tmp[$key] = &$params[$key];

            call_user_func_array(array($stmt_lookup, 'bind_param'), $tmp);
        }
        
        //==Check Not Equal Condtions=====//
        if(!empty($not_where_array))
        {
            $params = array();
            foreach($not_where_array as $field2 => $value2 )
            {   
                if(isset($params[0]))
                {
                    $params[0] .= 's';
                }
                else
                {
                    $params[0] = 's';
                }
                array_push($params, $value2);
            }
            
            
            foreach($params as $key => $value) 
            $tmp[$key] = &$params[$key];

            call_user_func_array(array($stmt_lookup, 'bind_param'), $tmp);
        }
        
        //==Check AND Like Condtions=====//
        if(!empty($and_like_array))
        {
            $params = array();
            foreach($and_like_array as $field3 => $value3 )
            {   
                if(isset($params[0]))
                {
                    $params[0] .= 's';
                }
                else
                {
                    $params[0] = 's';
                }
                array_push($params, $value3);
            }
            
            
            foreach($params as $key => $value) 
            $tmp[$key] = &$params[$key];

            call_user_func_array(array($stmt_lookup, 'bind_param'), $tmp);
        }
        
        //==Check AND Like Condtions=====//
        if(!empty($or_like_array))
        {
            $params = array();
            foreach($or_like_array as $field4 => $value4 )
            {   
                if(isset($params[0]))
                {
                    $params[0] .= 's';
                }
                else
                {
                    $params[0] = 's';
                }
                array_push($params, $value4);
            }
            
            
            foreach($params as $key => $value) 
            $tmp[$key] = &$params[$key];

            call_user_func_array(array($stmt_lookup, 'bind_param'), $tmp);
        }
        
        if($stmt_lookup->execute())
        {
            $result = $stmt_lookup->get_result();
            $rowCount = $result->num_rows;
            if($rowCount != 0 )
            {
                if($col=="")
                {
                    return $result;
                }
                else
                {
                    $row = $result->fetch_array();
                    return $row[$colums];
                }    
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;    
        }
    }

    //updated by punit 16072020 for prevention
    function update($table, $variables = array(), $where,$not_where_array=array(),$and_like_array=array(),$or_like_array=array())
    {
            //Make sure the array isn't empty
            global $db_con;
            if( empty( $variables ) )
            {
                return false;
                exit;
            }
            
            $sql = "UPDATE ". $table .' SET ';
            $fields = array();
            $values = array();
            
            foreach($variables as $field => $value )
            {   
                $sql  .= $field ."='".$value."' ,";
            }
            $sql   =chop($sql,',');
            
            $sql .=" WHERE 1 = 1 ";
            //==Check Where Condtions=====//
        if(!empty($where))
        {
            foreach($where as $field1 => $value1 )
            {   
                $sql  .= " AND ".$field1 ."= ? ";
            }
        }
        
        //==Check Not Equal Condtions=====//
        if(!empty($not_where_array))
        {
            foreach($not_where_array as $field2 => $value2 )
            {   
                $sql  .= " AND ".$field2 ."!= ? ";
            }
        }
        
        //==Check AND Like Condtions=====//
        if(!empty($and_like_array))
        {
            foreach($like_array as $field3 => $value3 )
            {   
                $sql  .= " AND ".$field3 ." like ? ";
            }
        }
        //==Check AND Like Condtions=====//
        if(!empty($or_like_array))
        {
            foreach($or_like_array as $field4 => $value4 )
            {   
                $sql  .= " AND ".$field4 ." like ? ";
            }
        }

            $stmt_update = $db_con->prepare($sql);
            
            //==Check Where Condtions=====//
            if(!empty($where))
            {
                $params = array();
                foreach($where as $field1 => $value1 )
                { 
                    if(isset($params[0]))
                    {
                        $params[0] .= 's';
                    }  
                    else
                    {
                        $params[0] = 's';
                    }
                    array_push($params, $value1);
                }
                
                
                foreach($params as $key => $value) 
                $tmp[$key] = &$params[$key];

                call_user_func_array(array($stmt_update, 'bind_param'), $tmp);
            }
            
            //==Check Not Equal Condtions=====//
            if(!empty($not_where_array))
            {
                $params = array();
                foreach($not_where_array as $field2 => $value2 )
                {   
                    if(isset($params[0]))
                    {
                        $params[0] .= 's';
                    }
                    else
                    {
                        $params[0] = 's';
                    }
                    array_push($params, $value2);
                }
                
                
                foreach($params as $key => $value) 
                $tmp[$key] = &$params[$key];

                call_user_func_array(array($stmt_update, 'bind_param'), $tmp);
            }
            
            //==Check AND Like Condtions=====//
            if(!empty($and_like_array))
            {
                $params = array();
                foreach($and_like_array as $field3 => $value3 )
                {   
                    if(isset($params[0]))
                    {
                        $params[0] .= 's';
                    }
                    else
                    {
                        $params[0] = 's';
                    }
                    array_push($params, $value3);
                }
                
                
                foreach($params as $key => $value) 
                $tmp[$key] = &$params[$key];

                call_user_func_array(array($stmt_update, 'bind_param'), $tmp);
            }
            
            //==Check AND Like Condtions=====//
            if(!empty($or_like_array))
            {
                $params = array();
                foreach($or_like_array as $field4 => $value4 )
                {   
                    if(isset($params[0]))
                    {
                        $params[0] .= 's';
                    }
                    else
                    {
                        $params[0] = 's';
                    }
                    array_push($params, $value4);
                }
                
                
                foreach($params as $key => $value) 
                $tmp[$key] = &$params[$key];

                call_user_func_array(array($stmt_update, 'bind_param'), $tmp);
            }
            
            if($stmt_update->execute())
            {
                return true;
            }
            else
            {
                return false;    
            }
    }

    //updated by punit 16072020 for prevention
    function delete($table,$where,$not_where_array=array(),$and_like_array=array(),$or_like_array=array())
    {
        //Make sure the array isn't empty
        global $db_con;
        
        
        $sql =" DELETE FROM ".$table." ";
        $sql .=" WHERE 1 = 1 ";
        
        //==Check Where Condtions=====//
        if(!empty($where))
        {
            foreach($where as $field1 => $value1 )
            {   
                $sql  .= " AND ".$field1 ."= ? ";
            }
        }
        
        //==Check Not Equal Condtions=====//
            if(!empty($not_where_array))
            {
                foreach($not_where_array as $field2 => $value2 )
                {   
                    $sql  .= " AND ".$field2 ."!= ? ";
                }
            }
        
        //==Check AND Like Condtions=====//
            if(!empty($and_like_array))
            {
                foreach($like_array as $field3 => $value3 )
                {   
                    $sql  .= " AND ".$field3 ." like ? ";
                }
            }
        //==Check AND Like Condtions=====//
            if(!empty($or_like_array))
            {
                foreach($or_like_array as $field4 => $value4 )
                {   
                    $sql  .= " AND ".$field4 ." like ? ";
                }
            }
        // return $sql;
        $stmt_delete = $db_con->prepare($sql);
        
        //==Check Where Condtions=====//
        if(!empty($where))
        {
            $params = array();
            foreach($where as $field1 => $value1 )
            {   
                if(isset($params[0]))
                {
                    $params[0] .= 's';
                }
                else
                {
                    $params[0] = 's';
                }
                array_push($params, $value1);
            }
            
            
            foreach($params as $key => $value) 
            $tmp[$key] = &$params[$key];

            call_user_func_array(array($stmt_delete, 'bind_param'), $tmp);
        }
        
        //==Check Not Equal Condtions=====//
        if(!empty($not_where_array))
        {
            $params = array();
            foreach($not_where_array as $field2 => $value2 )
            {   
                if(isset($params[0]))
                {
                    $params[0] .= 's';
                }
                else
                {
                    $params[0] = 's';
                }
                array_push($params, $value2);
            }
            
            
            foreach($params as $key => $value) 
            $tmp[$key] = &$params[$key];

            call_user_func_array(array($stmt_delete, 'bind_param'), $tmp);
        }
        
        //==Check AND Like Condtions=====//
        if(!empty($and_like_array))
        {
            $params = array();
            foreach($and_like_array as $field3 => $value3 )
            {   
                if(isset($params[0]))
                {
                    $params[0] .= 's';
                }
                else
                {
                    $params[0] = 's';
                }
                array_push($params, $value3);
            }
            
            
            foreach($params as $key => $value) 
            $tmp[$key] = &$params[$key];

            call_user_func_array(array($stmt_delete, 'bind_param'), $tmp);
        }
        
        //==Check AND Like Condtions=====//
        if(!empty($or_like_array))
        {
            $params = array();
            foreach($or_like_array as $field4 => $value4 )
            {   
                if(isset($params[0]))
                {
                    $params[0] .= 's';
                }
                else
                {
                    $params[0] = 's';
                }
                array_push($params, $value4);
            }
            
            
            foreach($params as $key => $value) 
            $tmp[$key] = &$params[$key];

            call_user_func_array(array($stmt_delete, 'bind_param'), $tmp);
        }
        
        if($stmt_delete->execute())
        {
            return true;
        }
        else
        {
            return false;    
        }
    }
?>