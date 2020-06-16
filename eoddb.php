<?php
include('dbconnection.php');
include('ManageEod.php');
include('ManageEodLogs.php');
$ManageEod= new ManageEod();
$ManageEodLogs = new ManageEodLogs();
//$data = $ManageEod -> getALLRecords();


session_start();
$prefix=$ticketnumber = $working_hrs = $description = $status = $estimatedtime = $login_time = $logout_time = $remainingtime = $completepercentage = $comments = $is_subticket = $main_ticket_no = $istesting = $iteration_no = $mark= array();

date_default_timezone_set("Asia/Calcutta");
$curent_date_time = date(" Y-m-d H:i:s");
$user_id=1174;
$user_name="Username";
$date=date("Y-m-d H:i:s");

if ($_POST) {
    $prefix             = ($_POST['prefix']);
    $ticketnumber       = ($_POST['ticketnumber']);
    $description        = ($_POST['description']);
    $status             = ($_POST['status']);
    $estimatedtime      = ($_POST['estimatedtime']);
    $login_time         = ($_POST['login_time']);
    $logout_time        = ($_POST['logout_time']);
    $remainingtime      = ($_POST['remainingtime']);
    $working_hrs        = ($_POST['working_hrs']);
    $completepercentage = ($_POST['completepercentage']);
    $comments           = ($_POST['comments']);
    $is_subticket       = ($_POST['is_subticket']);
    $main_ticket_no     = ($_POST['main_ticket_no']);
    $istesting          = ($_POST['istesting']);
    $iteration_no       = ($_POST['iteration_no']);
    $mark               = ($_POST['mark']);
}
 

if ($db) 
{
    $success=0;
    
    if($eod_id = $ManageEod->getEodIdByTicketnumber($ticketnumber))
    {       
        $existing_working_hrs = $ManageEod->getWorking_hrsByTicketnumber($ticketnumber);
        //echo $existing_working_hrs;
        $working_hrs = (int)($working_hrs) + (int)($existing_working_hrs); 
        //echo $working_hrs;
        $form_fields= array('user_id' => $user_id,
                            'user_name' => $user_name,
                            'prefix' => $prefix,
                            'description' => $description,
                            'status' => $status,
                            'estimated_time' => $estimatedtime,
                            'login_time' => $login_time,
                            'logout_time' => $logout_time,
                            'remaining_time' => $remainingtime,
                            'working_hrs' => $working_hrs,
                            'complete_percentage' => $completepercentage,
                            'mark' => $mark,
                            'comments' => $comments,
                            'is_subticket' => $is_subticket,
                            'main_ticket_no' => $main_ticket_no,
                            'is_testing' => $istesting,
                            'iteration_no' => $iteration_no,
                            'updated_time' => $curent_date_time,
                            'date' => $date);
                if($ManageEod->update($form_fields,$ticketnumber))
                    { 
                  
                        $success = 1;
                        $form_fields_2= array('eod_id' => $eod_id,
                            'user_name' => $user_name,
                            'status' => $status,
                            'login_time' => $login_time,
                            'logout_time' => $logout_time,
                            'remaining_time' => $remainingtime,
                            'complete_percentage' => $completepercentage,
                            'created_at' => $date);
                            if($ManageEodLogs->insert($form_fields_2))
                            {
                                $success = 1;
                            }
                            else
                            {
                                echo json_encode(['code' => 404, 'message'=> 'Database Insertion failure']);  
                                exit();
                            }
                  
                    }
                    else
                    {
                        echo json_encode(['code' => 404, 'message'=> 'Database Insertion failure']);  
                            exit();
                    }
            }

            else
            {
                $form_fields= array('user_id' => $user_id,
                            'user_name' => $user_name,
                            'ticket_number' => $ticketnumber,
                            'prefix' => $prefix,
                            'description' => $description,
                            'status' => $status,
                            'estimated_time' => $estimatedtime,
                            'login_time' => $login_time,
                            'logout_time' => $logout_time,
                            'remaining_time' => $remainingtime,
                            'complete_percentage' => $completepercentage,
                            'working_hrs'   => $working_hrs,
                            'mark' => $mark,
                            'comments' => $comments,
                            'is_subticket' => $is_subticket,
                            'main_ticket_no' => $main_ticket_no,
                            'is_testing' => $istesting,
                            'iteration_no' => $iteration_no,
                            'created_date_time'=> $curent_date_time,
                            'updated_time' => $curent_date_time,
                            'date' => $date);
                if($ManageEod->insert($form_fields))
                {
                    $success = 1;
                    $eod_id = $ManageEod->getEodIdByTicketnumber($ticketnumber);
                    $form_fields_2= array('eod_id' => $eod_id,
                            'user_name' => $user_name,
                            'status' => $status,
                            'login_time' => $login_time,
                            'logout_time' => $logout_time,
                            'remaining_time' => $remainingtime,
                            'complete_percentage' => $completepercentage,
                            'created_at' => $date);
                            if($ManageEodLogs->insert($form_fields_2))
                            {
                                $success = 1;
                            }
                            else
                            {
                                echo json_encode(['code' => 404, 'message'=> 'Database Insertion failure']);  
                                
                            }
                }
                else
                {
                    echo json_encode(['code' => 404, 'message'=> 'Database Insertion failure']);  
                                
               }
            }
    }


if($success === 1){
    echo json_encode([
       'code' => 200,
    'message'=> 'You have successfully submitted your end of the day report'
         ]);
}
else 
{
    echo json_encode([
       'code' => 404,
    'message'=> 'Database connection failure'
]);
    
}

?>






