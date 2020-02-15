<?php

//Include Functions
include('includes/Functions.php');

//Include Notifications
include ('includes/notification.php');


$SearchTerm = '';

if (isset($_POST['submitin'])) {
	
		$IncomeIds = $_POST['incomeid'];	
		//Get Account Id
		$GetAccountId = "SELECT AccountId FROM assets WHERE UserId = $UserId and AssetsId = $IncomeIds";
		$AccountId = mysqli_query($mysqli,$GetAccountId);
		$ColId = mysqli_fetch_array($AccountId);
		$AccId = $ColId['AccountId'];
		//Delete Income
		$Delete = "DELETE FROM assets WHERE AssetsId = $IncomeIds";
		$DeleteI = mysqli_query($mysqli,$Delete); 
		
		//Update Total Income
		$TotalIncome = "UPDATE totals SET totals.Totals = (SELECT SUM(Amount) FROM assets where assets.UserId = $UserId AND assets.AccountId = totals.AccountId) \n"
    . "	WHERE totals.UserId = $UserId AND totals.AccountId = $AccId";
		$UpdateTotalIncome = mysqli_query($mysqli,$TotalIncome);
		if(!$UpdateTotalIncome){
			$Gagal="QUERY ERROR";
				 $msgBox = alertBox($Gagal);
			}
		//$msgBox = alertBox($AccId);
		$msgBox = alertBox($DeleteIncome);
	}
	
//Get Report bills History
$GetExpenseHistory = "SELECT * from bills left join category on bills.CategoryId = category.CategoryId left join account on bills.AccountId = account.AccountId where bills.UserId = $UserId ORDER BY bills.Dates DESC";
$ExpenseHistory = mysqli_query($mysqli,$GetExpenseHistory); 


// Get all Expense
$GetAllBillsOverall    = "SELECT SUM(Amount) AS Amount FROM bills WHERE UserId = $UserId ";
$GetABillsOverall      = mysqli_query($mysqli, $GetAllBillsOverall);
$BillsColOverall       = mysqli_fetch_assoc($GetABillsOverall);
$BillsOverall          = $BillsColOverall['Amount'];

// Get all by month Expense
$GetAllBillsDate    = "SELECT SUM(Amount) AS Amount FROM bills WHERE UserId = $UserId AND MONTH(Dates) = MONTH (CURRENT_DATE())";
$GetABillsDate      = mysqli_query($mysqli, $GetAllBillsDate);
$BillsColDate       = mysqli_fetch_assoc($GetABillsDate);
$BillThisMonth      = $BillsColDate['Amount'];

// Get all by today Expense
$GetAllBillsToday           = "SELECT SUM(Amount) AS Amount FROM bills WHERE UserId = $UserId AND Dates = CURRENT_DATE()";
$GetABillsDateToday         = mysqli_query($mysqli, $GetAllBillsToday);
$BillsColDateToday          = mysqli_fetch_assoc($GetABillsDateToday);
$BillToday                  = $BillsColDateToday['Amount'];



// Search Income
if (isset($_POST['searchbtn'])) {
	$SearchTerm = $_POST['search'];
	$GetIncomeHistory = "SELECT * from assets left join category on assets.CategoryId = category.CategoryId left join account on assets.AccountId = account.AccountId where 
					(assets.Title like '%$SearchTerm%' 
					OR account.AccountName like '%$SearchTerm%'
					OR assets.Description like '%$SearchTerm%' 
					OR category.CategoryName like '%$SearchTerm%')
					AND assets.UserId = $UserId ORDER BY assets.Date DESC";
$IncomeHistory = mysqli_query($mysqli,$GetIncomeHistory); 
	
}



//Include Global page
	include ('includes/global.php');
	
	
?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo $ExpenseSummary ;?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <?php if ($msgBox) { echo $msgBox; } ?>
           
            <div class="row">
				<div class="col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> <?php echo $OverallReport; ?>
                        </div>
                        <div class="panel-body">
                            <p class="btn btn-primary"><?php echo $TotalExpenseToday; ?> <?php echo $ColUser['Currency'].' '.number_format($BillsOverall);?></p><br/><br/>
                            <p class="btn btn-warning"><?php echo $TotalExpenseThisMonth; ?> <?php echo $ColUser['Currency'].' '.number_format($BillThisMonth);?></p><br/><br/>
                            <p class="btn btn-info"><?php echo $TotalExpenseReport; ?> <?php echo $ColUser['Currency'].' '.number_format($BillToday);?></p><br/><br/>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                           <i class="glyphicon glyphicon-stats"></i> <?php echo $HistoryofExpense ;?>
                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<div class="pull-right">
								<form action="" method="post">
							<div class="form-group input-group col-lg-5	pull-right">
                                            <input type="text" name="search" placeholder="<?php echo $Search ;?>" class="form-control">
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" name="searchbtn" type="input"><i class="fa fa-search"></i>
                                                </button>
                                            </span> 
                                 </div>
                                 </form> 
                                 
                            </div>     
                            <div class="">
                                <table class="table table-bordered table-hover table-striped" id="assetsdata">
                                    <thead>
        			                <tr>
        			                    <th class="text-left"><?php echo $Title ;?></th>
        			                    <th class="text-left"><?php echo $Date ;?></th>
        			                    <th class="text-left"><?php echo $Category ;?></th>
        			                    <th class="text-left"><?php echo $Account ;?></th>
        			                    <th class="text-left"><?php echo $Description ;?></th>
        			                    <th class="text-left"><?php echo $Amount ;?></th>        			                   
        			                </tr>
			                     </thead>

	                	<tbody>
							 <?php while($col = mysqli_fetch_assoc($ExpenseHistory)){ ?>
							<tr>
							<td><?php echo $col['Title'];?></td>
							<td><?php echo date("M d Y",strtotime($col['Date']));?></td>
							<td><?php echo $col['CategoryName'];?></td>
							<td><?php echo $col['AccountName'];?></td>
							<td><?php echo $col['Description'];?></td>
							<td><?php echo $ColUser['Currency'].' '.number_format($col['Amount']);?></td>
							
							</tr>
	                	</tbody>
	                	

								
	                		 <?php } ?>   
						
		                <tfoot>
			                <tr>
			                    <th class="text-left"><?php echo $Title ;?></th>
			                    <th class="text-left"><?php echo $Date ;?></th>
			                    <th class="text-left"><?php echo $Category ;?></th>
			                    <th class="text-left"><?php echo $Account ;?></th>
			                    <th class="text-left"><?php echo $Description ;?></th>
			                    <th class="text-left"><?php echo $Amount ;?></th>      
			                </tr>
		                </tfoot>
	           			</table>
                            </div>
                            <!-- /.table-responsive -->
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    
                </div>
             
               
                <!-- /.col-lg-4 -->
            </div>
            <a href="pages/ExpenseReportPdf.php?filter=<?php echo $SearchTerm; ?>" class="btn white btn-warning"><i class="glyphicon glyphicon-download-alt"></i> <?php echo $DownloadExpenseReports; ?></a>
            <a href="pages/ExpenseReportCSV.php?filter=<?php echo $SearchTerm; ?>" class="btn white btn-warning"><i class="glyphicon glyphicon-download-alt"></i> <?php echo $DownloadExpenseCSV; ?></a>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                   
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->
   

