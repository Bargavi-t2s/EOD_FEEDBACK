<?php

include('dbconnection.php');
include('managefeedback.php'); 

$ManageFeedback = new ManageFeedback();

ob_start();

$ticketnumber=($_POST['ticketnumber']);
$prefix      =($_POST['prefix']);
$output='';
$j=0;

if($db)
{
	$i=$ManageFeedback->get_timelinedetails($ticketnumber, $prefix);
		foreach($i as $row)
		{
			$j=$j+1;
			if(($j%2) == 0)
			{

	$output.='<div class="container2 right animate fadeInUp">
    <div class="content1">
     <h6>'.$row["created_at"].'</h6>
     Status : '.$row["status"].'<br>
     Compelete percentage : '.$row["complete_percentage"].'<br>
     Remaining time : '.$row["remaining_time"].'<br>
     </div>
  </div>';
}
else
{

$output.='<div class="container2 left animate fadeInUp">
    <div class="content1">
     <h6>'.$row["created_at"].'</h6>
     Status : '.$row["status"].'<br>
     Compelete percentage : '.$row["complete_percentage"].'<br>
     Remaining time : '.$row["remaining_time"].'<br>
     </div>
     </div>';
}
}







		ob_end_clean();
		echo json_encode(array('timeline_output'=>$output));
}
else
{
	echo "Database Connection Failed";
}
?>