<?php 
session_start();
$UserId=$_SESSION['UserId'];

require_once('../includes/db.php');

//echo $UserId;
//Get userinfo

$GetUserInfo = "SELECT * FROM user WHERE UserId = $UserId";
$UserInfo = mysqli_query($mysqli, $GetUserInfo);
$ColUser = mysqli_fetch_assoc($UserInfo);

$SearchTerm = $_GET['filter'];


if($SearchTerm==''){
//Get Report Expense History
$GetExpenseHistory = "SELECT BillsId, Title, Dates,CategoryName, bills.AccountId,AccountName, Amount, Description from bills left join category on bills.CategoryId = category.CategoryId left join account on bills.AccountId = account.AccountId where bills.UserId = $UserId ORDER BY bills.Dates DESC";
$ExpenseReport = mysqli_query($mysqli,$GetExpenseHistory); 
}
else{

// Filter Report Expense
	$GetExpenseHistory = "SELECT BillsId, Title, Dates,CategoryName, bills.AccountId,AccountName, Amount, Description from bills left join category on bills.CategoryId = category.CategoryId left join account on bills.AccountId = account.AccountId where 
					(bills.Title like '%$SearchTerm%' 
					OR account.AccountName like '%$SearchTerm%'
					OR bills.Description like '%$SearchTerm%' 
					OR category.CategoryName like '%$SearchTerm%')
					AND bills.UserId = $UserId ORDER BY bills.Dates DESC";
$ExpenseReport = mysqli_query($mysqli,$GetExpenseHistory); 
	
$field = mysqli_num_fields($ExpenseReport);
}
$setCounter = 0;

$setExcelName = date("Ymd");


$setRec = $ExpenseReport;

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

header("Content-Disposition: attachment; filename=".$setExcelName."_Expenses_Report.xls");

header("Pragma: no-cache");
header("Expires: 0");




?>