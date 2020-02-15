<?php

session_start();
//Include Database

include('db.php');
//Include Functions
include('Functions.php');

//Include Notifications
include ('notification.php');

// Get User Info
$UserId=$_SESSION['UserId'];
$GetUserInfo = "SELECT * FROM user WHERE UserId = $UserId";
$UserInfo = mysqli_query($mysqli, $GetUserInfo);
$ColUser = mysqli_fetch_assoc($UserInfo);
	
// fetch data to calender
$query 				   = "select * from bills where UserId = $UserId ";
$assetstocalender      = mysqli_query($mysqli, $query);
$events = array();
$sum = 0;
while ($row = mysqli_fetch_assoc($assetstocalender)) {
    $start = $row['Dates'];
    $end   = $row['Dates'];
    $amount = $ColUser['Currency'].' '.number_format($row['Amount']);
    $title = $row['Title'];
    $sum+= $row['Amount'];
    
    $eventsArray['title'] = $title;
    $eventsArray['start'] = $start;
    $eventsArray['end'] = $end;
    $eventsArray['names'] = $amount;
    $events[] = $eventsArray;
}
$eventsArray['sum'] = $sum;
echo json_encode($events);	
//echo $sum;	
	
?>
