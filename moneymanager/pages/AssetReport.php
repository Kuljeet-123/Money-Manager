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
	
//Get Report Income History
$GetIncomeHistory = "SELECT * from assets left join category on assets.CategoryId = category.CategoryId left join account on assets.AccountId = account.AccountId where assets.UserId = $UserId ORDER BY assets.Date DESC";
$IncomeHistory = mysqli_query($mysqli,$GetIncomeHistory); 


// Get all by month Income
$GetAllIncomeDate 	 = "SELECT SUM(Amount) AS Amount FROM assets WHERE UserId = $UserId AND MONTH(Date) = MONTH (CURRENT_DATE())";
$GetAIncomeDate		 = mysqli_query($mysqli, $GetAllIncomeDate);
$IncomeColDate 		 = mysqli_fetch_assoc($GetAIncomeDate);

// Get all by today Income
$GetAllIncomeDateToday 		 = "SELECT SUM(Amount) AS Amount FROM assets WHERE UserId = $UserId AND Date = CURRENT_DATE()";
$GetAIncomeDateToday		 = mysqli_query($mysqli, $GetAllIncomeDateToday);
$IncomeColDateToday 		 = mysqli_fetch_assoc($GetAIncomeDateToday);



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
                    <h1 class="page-header"><?php echo $AssetReports ;?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <?php if ($msgBox) { echo $msgBox; } ?>
           <a href="index.php?page=Transaction" class="btn white btn-success "><i class="fa fa-plus"></i> <?php echo $NewTransaction; ?></a>
           <a href="pages/IncomeReportPdf.php?filter=<?php echo $SearchTerm; ?>" class="btn white btn-warning"><i class="glyphicon glyphicon-download-alt"></i> <?php echo $DownloadIncomeReports; ?></a>
           <a href="pages/IncomeReportCSV.php?filter=<?php echo $SearchTerm; ?>" class="btn white btn-warning"><i class="glyphicon glyphicon-download-alt"></i> <?php echo $DownloadIncomeCSV; ?></a>
            <div class="row">
				
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                           <i class="glyphicon glyphicon-stats"></i> <?php echo $HistoryofAssets ;?>
                            
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
        			                    <th class="text-left"><?php echo $Action ;?></th>
        			                   
        			                </tr>
			                     </thead>

	                	<tbody>
							 <?php while($col = mysqli_fetch_assoc($IncomeHistory)){ ?>
							<tr>
							<td><?php echo $col['Title'];?></td>
							<td><?php echo date("M d Y",strtotime($col['Date']));?></td>
							<td><?php echo $col['CategoryName'];?></td>
							<td><?php echo $col['AccountName'];?></td>
							<td><?php echo $col['Description'];?></td>
							<td><?php echo $ColUser['Currency'].' '.number_format($col['Amount']);?></td>
							<td colspan="2" class="notification">
								<a href="index.php?page=ManageIncome&id=<?php echo $col['AssetsId'];?>" class="" data-toggle="modal"><span class="btn btn-primary btn-xs glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo $EditIncome ;?>"></span></a>
								<a href="#DeleteIncome<?php echo $col['AssetsId'];?>"  data-toggle="modal"><span class=" glyphicon glyphicon-trash btn btn-primary btn-xs" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo $DeleteIncomes ;?>"></span></button>			
							</td>
							</tr>
	                	</tbody>
	                	<div class="modal fade" id="DeleteIncome<?php echo $col['AssetsId'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
                                <div class="modal-dialog">
                                    <div class="modal-content">
									<form action="" method="post">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"><?php echo $AreYouSure ;?></h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo $ThisItem ;?>
                                        </div>
                                        <div class="modal-footer">
											 
											<input type="hidden" id="incomeid" name="incomeid" value="<?php echo $col['AssetsId']; ?>" />
											<button type="input" id="submit" name="submitin" class="btn btn-primary"><?php echo $Yes ;?></button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $Cancel ;?></button>
                                            </form>
                                        </div>
                                       
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->

								
	                		 <?php } ?>   
						
		                <tfoot>
			                <tr>
			                    <th class="text-left"><?php echo $Title ;?></th>
			                    <th class="text-left"><?php echo $Date ;?></th>
			                    <th class="text-left"><?php echo $Category ;?></th>
			                    <th class="text-left"><?php echo $Account ;?></th>
			                    <th class="text-left"><?php echo $Description ;?></th>
			                    <th class="text-left"><?php echo $Amount ;?></th>
			                    <th class="text-left"><?php echo $Action ;?></th>        
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
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                   
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->
   

