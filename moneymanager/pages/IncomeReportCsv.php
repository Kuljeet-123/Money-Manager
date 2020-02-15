<?php 
session_start();
$UserId=$_SESSION['UserId'];

//include database file
require_once('../includes/db.php');



//Get userinfo

$GetUserInfo = "SELECT * FROM user WHERE UserId = $UserId";
$UserInfo = mysqli_query($mysqli, $GetUserInfo);
$ColUser = mysqli_fetch_assoc($UserInfo);


//Get Report Income History
$GetIncomeHistory = "SELECT AssetsId,Title,Date,assets.CategoryId,CategoryName, assets.AccountId,AccountName,Description from assets left join category on assets.CategoryId = category.CategoryId left join account on assets.AccountId = account.AccountId where assets.UserId = $UserId ORDER BY assets.Date DESC";
$IncomeReport = mysqli_query($mysqli,$GetIncomeHistory); 
$columns_total = mysqli_num_fields($IncomeReport);

// Filter Report Income

	$SearchTerm = $_GET['filter'];
	$GetIncomeHistory = "SELECT AssetsId,Title,Date,assets.CategoryId,CategoryName, assets.AccountId,AccountName,Description from assets left join category on assets.CategoryId = category.CategoryId left join account on assets.AccountId = account.AccountId where 
					(assets.Title like '%$SearchTerm%' 
					OR account.AccountName like '%$SearchTerm%'
					OR assets.Description like '%$SearchTerm%' 
					OR category.CategoryName like '%$SearchTerm%')
					AND assets.UserId = $UserId ORDER BY assets.Date DESC";
$IncomeReport = mysqli_query($mysqli,$GetIncomeHistory); 

$setCounter = 0;

$setExcelName = date("Ymd");


$setRec = $IncomeReport;

//do convert to excel
$setCounter = mysqli_num_fields($setRec);
$setMainHeader = '';
for ($i = 0; $i < $setCounter; $i++) {
    $setMainHeader1 = mysqli_fetch_field_direct($setRec, $i);
    $setMainHeader .= $setMainHeader1->name."\t";
}
echo ucwords($setMainHeader)."\n";
while($rec = mysqli_fetch_assoc($setRec))  {
  $rowLine = '';
  $setData = '';
  foreach($rec as $value)       {
    if(!isset($value) || $value == "")  {
      $value = "\t";
    }   else  {
//It escape all the special charactor, quotes from the data.
      $value = strip_tags(str_replace('"', '""', $value));
      $value = '' . $value . '' . "\t";
    }
    $rowLine .= $value;
  }
  $setData .= trim($rowLine)."\n";
  echo $setData;
}
  $setData = str_replace("\r", "", $setData);

if ($setData == "") {
  $setData = "No matching records found";
}

$setCounter = mysqli_num_fields($setRec);



//This Header is used to make data download instead of display the data
header("Content-Type: application/xls");    

header("Content-Disposition: attachment; filename=".$setExcelName."_Income_Report.xls");

header("Pragma: no-cache");
header("Expires: 0");
?>