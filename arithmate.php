<?php
//subject_id (Arihtmetic) = 6
//topic_id (fraction) = 15

//1st Part
//sub_topic_id (Introduction to fraction) = 110,
//child-topic id / obj_id (what are fraction, Numerators and denoim) 114, 111

//2nd Part
//sub_topic_id (addition) = 11
//child_topic_id / obj_id  12,13

//3rd Part
//sub_topic_id (Introduction to fraction) = 110,
//child-topic id / obj_id (what are fraction, Numerators and denoim) = 113


function findNextSequence(sub_topic_id,obj_id,userid,prev_act,prev_act_status,next_act,next_act_status,gotonext,pre_req_id(from id),pre_req_status){
    
    //first time entry - (110,'',1,'','','','',0,0,0)
    //second time entry - (110,114,1,FLASH,2,IS,1,0,0,0);

    //third time entry - (110,114,1,IS,2,QTYPE,1,0,0,0);
    
    //four time entry - (110,114,1,QTYP2,2,,,1,0,0)
    //five time entry - (110,111,1,video,2,QType,1,0,0,0)

    //pre-requiste
    //Six time entry - (11,'',1,'','','','',0,111,1)
    //Seven time entry - (11,12,1,flash,2,video,1,0,111,1)
    //Eight time entry - (11,12,1,video,2,qtype,1,0,111,1) 

    //Nine Time entry - (11,12,1,QTYPE,2,'','',1,111,1)

    //ten time entry - (11,13,1,VIDEO,2,'','',1,111,1)

    //eleven time entry - findNextSequence(110,111,1,'','','QTYPE','1',0,0,0)
    
    if(objid == "blank" or objid == "null")
    {
     
        if(pre_req_status == 0){
            pre_req_id = 0
            // create the entry in `mcq_error_table` with "sub_topic_id (110)" and "userid"
        }
        else{
            pre_req_id = 111
        }

        
        //Normal - Query to  obj_id/child_topic_id using sub_topic_id (110) in tbl_topic table using sort order and limit 0,1
        //Pre-req - Query to  obj_id/child_topic_id using sub_topic_id (11) in tbl_topic table using sort order and limit 0,1
        
        //Normal - create the entry in `NEWTABLE` with sub_topic_id(110), obj_id (114)
        //Pre-req - create the entry in `NEWTABLE` with sub_topic_id(11), obj_id (12)
        
        //Normal & Pre - NEWTABLE id,pre_requiste_id, objective id, student_id, isession_status, isession_start_date, isession_end_date, video_status, video_start_date, video_end_date, flashcard_status, flashcard_start_date, flashcard_end_date, visual_qtype_status, visual_qtype_start_date, visual_qtype_end_date, qtype_status, qtype_start_date, qtype_end_date, gotonext_status created_date

        // user-1|obj-114|
        //objid of the very first objective/first child_id
        loadActivitySequence(objid)    
        //NORMAL - OBJ-114 [1-flash,2-IS,3-QTYPE] 1,0,0,3,3 
        
        

        if(first_sequence_data == 'QTYPE')
        {
            //take that sub_topic_id 
            //fetch the qlm_ids with qtype_id(220,221,222), sub_topic_id(110) and obj_id (111,112) from `qtype_lookup master`
            // Normal Flow (QUESTION_GENERATION)  ---> tbl_topic_lookup_child,tbl_topic_lookup_child_details
            
            // return  Question generated JSON, row_data, Sequence Data (OBBJ111-1-flash,2-IS,3-QTYPE)
        }
        else
        {
            //Normal - return  row_data, Sequence Data (OBJ1-11 [1-flash,2-IS,3-QTYPE])
            //Pre-Requiste - return  row_data, Sequence Data (OBJ-12 [1-flash,2-video,3-Qtype])
        }
    }
    else
    {
        if(gotonext == 1)
        {
            //4th time  entry
            //update the current objid's gotonext_status = 1 in "New Table"
            //Query to select next obj from "tbl_topic" where sub_topic_id=110 and topic_id not in (114) sort order by sort_id limit 0,1

            //9th time entry
            //update the current objid's gotonext_status = 1 in "New Table"
            //Query to select next obj from "tbl_topic" where sub_topic_id=11 and topic_id not in (12) sort order by sort_id limit 0,1


            //10th time entry
            //update the current objid's gotonext_status = 1 in "New Table"
            //Query to select next obj from "tbl_topic" where sub_topic_id=11 and topic_id not in (12,13) sort order by sort_id limit 0,1
            
            
            if(objidstat) // if num_rows = 1 then
            {

                
                
                if(pre_req_status == 0)
                {
                   // create the entry for 111 in the NEWTABLE
                }
                else
                {
                   // create the entry for 13 in the NEWTABLE with pre_requiste = 111, pre_requiste_status = 1    
                }

                loadActivitySequence(objid)
                //OBJ111 [1-Video,2-QTYPE]
                //OBJ13 [1-video]
                    if(first_sequence_data == 'QTYPE')
                    {
                        //take that sub_topic_id 
                        //fetch the qlm_ids with qtype_id(220,221,222), sub_topic_id(110) and obj_id (111,112) from `qtype_lookup master`
                        // Normal Flow (QUESTION_GENERATION)  ---> tbl_topic_lookup_child,tbl_topic_lookup_child_details
                        
                        // return  Question generated JSON, row_data, Sequence Data (OBBJ111-1-flash,2-IS,3-QTYPE)
                    }
                    else{
                        // return   row_data, Sequence Data (OBBJ111-1-flash,2-IS,3-QTYPE)
                    }
                
            }
            else //else num_rows = 0
            {

                if(pre_req_status == 0)
                {
                    //find the next sub-topic_id (120)
                    findNextSequence(120,'',1,'','','','',0)
                }
                elseif(pre_req_status == 1) 
                {
                    findNextSequence(110,111,1,'','','QTYPE','1',0,0,0)

                }
                
            }
            
        }
        else{
            if(next_act == 'QTYPE')
            {
                if(pre_req_status == 0)
                {
                   
                    //take that sub_topic_id 
                    //fetch the qlm_ids with qtype_id(220,221,222), sub_topic_id(110) and obj_id (111) from `qtype_lookup master`
                    // Normal Flow (QUESTION_GENERATION)  ---> tbl_topic_lookup_child,tbl_topic_lookup_child_details
                    
                    //update the record with for 111 - Interactive_session = 2,Qtype = 1
                    //return true, Question generated JSON   
                }
                else
                {
                
                    //check objid(12) and sub_topic_id(11) in pre_requiste_child and pre_requiste_child_details
                    //and fetch the JSON
                
                    //update the record with for 111 - Interactive_session = 2,Qtype = 1
                    //return true, Question generated JSON  
                }


                

                //eight time entry   
                //take that sub_topic_id(11) 
                //fetch the qlm_ids with qtype_id(), sub_topic_id(11) and obj_id (12) from `qtype_lookup master`
                // Normal Flow (QUESTION_GENERATION)  ---> tbl_topic_lookup_child,tbl_topic_lookup_child_details
                
                //update the record with for 111 - Interactive_session = 2,Qtype = 1
                //return true, Question generated JSON

            }
            else{

                    //2nd time entry
                    //update the record with for 114 - flashcard = 2, Interactive_session = 1
                    //return  true;

                    //seven time entry
                    //update the record with for 12 - flashcard = 2, video = 1
                    //return  true;

                }
        }
    }

}


function loadActivitySequence(objid)
{

        //will get timeline JSON 
        // Fetch obj_id and the sequence of each activity from JSON
        // (Activity is present (not yet started) = 0, Activity not present = 3, Current Activity = 1, Completed = 2)
        // find whats there in sequence (FLASH,IS,QTYPE) not in sequence(video,video_qtype)
        // Associate array on server as per prathamesh
        // In response to the app, send the complete row from new table with updated status (no need to recheck the sequence on local db)

        return the sequence of activity (1-activity 1,2- activity 3,3 - activity 2)

}


?>