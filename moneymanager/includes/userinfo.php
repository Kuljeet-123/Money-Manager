<?php
// Get User Info
$UserId = $_SESSION['UserId'];	
$GetUserInfo = "SELECT * FROM user WHERE UserId = $UserId";
$UserInfo = mysqli_query($mysqli, $GetUserInfo);
	$ColUser = mysqli_fetch_assoc($UserInfo);

?>
