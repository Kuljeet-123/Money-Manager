<?php

// include connection to database
include ('includes/db.php');


// Get User Info
$UserId=$_SESSION['UserId'];
$GetUserInfo = "SELECT * FROM user WHERE UserId = $UserId";
$UserInfo = mysqli_query($mysqli, $GetUserInfo);
$ColUser = mysqli_fetch_assoc($UserInfo);



//category for income
$Getincome = "SELECT CategoryId, UserId, CategoryName, Level FROM category WHERE (UserId = 0 OR UserId = $UserId) AND Level = 1";
$income = mysqli_query($mysqli,$Getincome); 

					
// Category for Expense
$Getexpense = "SELECT CategoryId, UserId, CategoryName, Level FROM category WHERE (UserId = 0 OR UserId = $UserId) AND Level = 2";
$expense = mysqli_query($mysqli,$Getexpense); 

// Category for account Expense
$GetAccountExpense = "SELECT AccountId, UserId, AccountName FROM account WHERE UserId = 0 OR UserId = $UserId";
$AccountExpense = mysqli_query($mysqli,$GetAccountExpense); 

// Category for account Income
$GetAccountIncome = "SELECT AccountId, UserId, AccountName FROM account WHERE UserId = 0 OR UserId = $UserId";
$AccountIncome = mysqli_query($mysqli,$GetAccountIncome); 


/* CHART QUERY HERE
 * 
 */
// get data based from account
$GetAccountDount = "SELECT account.AccountName, sum(assets.Amount) AS Amount FROM account, assets where account.AccountId=assets.AccountId AND assets.UserId= $UserId group by account.AccountName";
$Dount = mysqli_query($mysqli, $GetAccountDount);

$GetAccountDounts = "SELECT category.CategoryName, SUM(bills.amount) AS Amount FROM category, bills where category.CategoryId=bills.CategoryId AND category.Level = 2 AND bills.UserId = $UserId GROUP BY bills.CategoryId";
$Dounts = mysqli_query($mysqli, $GetAccountDounts);

// dashboard income vs expense
$GetAccountDountvs = "SELECT AmountExpense, AmountIncome
					  FROM (  SELECT  UserId, 
                      SUM(Amount) AS AmountExpense
                      FROM bills
				      GROUP BY UserId) AS b
					  LEFT JOIN ( SELECT  UserId,
                      SUM(Amount) AmountIncome
				      FROM assets
					  GROUP BY UserId) AS a
					  ON b.UserId = a.UserId
					  WHERE b.UserId = $UserId";
$Dountvs = mysqli_query($mysqli, $GetAccountDountvs);
$colsDounat = mysqli_fetch_assoc($Dountvs);


// income vs expense by month

$GetAccountDountdate = "SELECT AmountExpense, AmountIncome
					  FROM (  SELECT  UserId, 
                      SUM(Amount) AS AmountExpense, dates
                      FROM bills WHERE MONTH(Dates) = MONTH(current_date())
				      GROUP BY UserId) AS b
					  JOIN ( SELECT  UserId,
                      SUM(Amount) AS AmountIncome, date
				      FROM assets WHERE MONTH(Date) = MONTH(current_date())
					  GROUP BY UserId) AS a
					  ON b.UserId = a.UserId
					  WHERE b.UserId = $UserId";
$Dountvsdate 	 = mysqli_query($mysqli, $GetAccountDountdate);
$ColsDounatMonth = mysqli_fetch_assoc($Dountvsdate);

// get data based from budget
$Year 	= date("Y");
$Month  = date("m");
$Getbudget = "SELECT b.CategoryId, b.Dates, b.Amount, c.CategoryName from budget b, category c WHERE YEAR(Dates) = $Year  AND MONTH(Dates) = $Month AND b.UserId = $UserId AND c.CategoryId = b.CategoryId";
$Budget = mysqli_query($mysqli, $Getbudget);



/* For PDF Report */

//Get Report Income History
$GetIncomeHistory = "SELECT * from assets left join category on assets.CategoryId = category.CategoryId left join account on assets.AccountId = account.AccountId where assets.UserId = $UserId ORDER BY assets.Date DESC";
$IncomeReport = mysqli_query($mysqli,$GetIncomeHistory); 



?>
