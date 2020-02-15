<?php

//Include Functions
include('includes/Functions.php');

//Include Notifications
include ('includes/notification.php');

// add new budget
if (isset($_POST['submit'])) {
		
		//check already add budget
		$CategoryId = $_POST['category'];
		$CheckBudget = "SELECT CategoryId from budget WHERE UserId = $UserId AND MONTH(Dates) = MONTH (CURRENT_DATE()) AND CategoryId = $CategoryId";
		$CBudget = mysqli_query($mysqli, $CheckBudget);
		if($Check= mysqli_num_rows($CBudget) > 0){
			
				$msgBox = alertBox($AlreadyBudget);
			}else{
				$date		= date("Y-m-d");
				$CategoryId = $_POST['category'];
				$Amount		= clean($_POST['amount']);
				//add new budget
				$sql="INSERT INTO budget (UserId, CategoryId, Dates, Amount) VALUES (?,?,?,?)";
				if($statement = $mysqli->prepare($sql)){
					
					//bind parameters for markers, where (s = string, i = integer, d = double,  b = blob)
					$statement->bind_param('iisi',$UserId, $CategoryId, $date, $Amount);	
					$statement->execute();
				}

				$msgBox = alertBox($SaveMsgBudget);
			}	
	}


//Edit budget
if(isset($_POST['edit'])){
		$BudgetsIds = $_POST['budgetsids'];
		$Amount = clean($_POST['amountedit']);
		
		$sql="UPDATE budget SET Amount = ? WHERE BudgetId = $BudgetsIds";
		if($statement = $mysqli->prepare($sql)){
			//bind parameters for markers, where (s = string, i = integer, d = double,  b = blob)
			$statement->bind_param('i', $Amount);	
			$statement->execute();
			
		}
		$msgBox = alertBox($UpdateMsgBudget);
	}


//delete budget

if(isset($_POST['deletebudget'])){
		$BudgetId = $_POST['budgetid'];
		$Delete = "DELETE FROM budget WHERE BudgetId = $BudgetId";
		$DeleteI = mysqli_query($mysqli,$Delete); 
		
		$msgBox = alertBox($DeleteBudget);
	}


// history budget
$Year 	= date("Y");
$Month  = date("m");
$Getbudgets = "SELECT b.BudgetId, b.CategoryId, b.Dates, b.Amount, c.CategoryName from budget b, category c WHERE YEAR(Dates) = $Year  AND MONTH(Dates) = $Month AND b.UserId = $UserId AND c.CategoryId = b.CategoryId";
$Budgets = mysqli_query($mysqli, $Getbudgets);

//Include Global page
	include ('includes/global.php');
	
	
?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo $ManageBudget; ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <?php if ($msgBox) { echo $msgBox; } ?>
            <a href="#new" class="btn white btn-success " data-toggle="modal"><i class="fa fa-plus"></i> <?php echo $NewBudgets; ?></a>
            <div class="row">
				
                
             
               
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <i class="fa fa-archive"></i> <?php echo $HistoryofBudget; ?>
                            
                        </div>
                        <!-- /.panel-heading -->
                       
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="assetsdata">
                                    <thead>
			                <tr>
			                    <th class="text-left"><?php echo $Category; ?></th>
			                    <th class="text-left"><?php echo $Date; ?></th>
			                    <th class="text-left"><?php echo $Amounts; ?></th>
			                    <th class="text-left"><?php echo $Action; ?></th> 
			                </tr>
			             </thead>

	                	<tbody>
							 <?php while($col = mysqli_fetch_assoc($Budgets)){ ?>
							<tr>
							<td><?php echo $col['CategoryName'];?></td>
							<td><?php echo date("F",strtotime($col['Dates'])).' '.date("Y",strtotime($col['Dates']));?></td>
							
							<td><?php echo $ColUser['Currency'].' '.number_format($col['Amount']);?></td>
							<td colspan="2" class="notification">
								<a href="#EditBudget<?php echo $col['BudgetId'];?>" class="" data-toggle="modal"><span class="btn btn-primary btn-xs glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo $EditBudget; ?>"></span></a>
								<a href="#DeleteBudget<?php echo $col['BudgetId'];?>"  data-toggle="modal"><span class=" glyphicon glyphicon-trash btn btn-primary btn-xs" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo $DeleteBudgets; ?>"></span></button>			
							</td>
							</tr>
	                	</tbody>
	                	<div class="modal fade" id="DeleteBudget<?php echo $col['BudgetId'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
                                <div class="modal-dialog">
                                    <div class="modal-content">
									<form action="" method="post">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"><?php echo $AreYouSure; ?></h4>
                                        </div>
                                        <div class="modal-body">
                                           <?php echo $ThisItem; ?>
                                        </div>
                                        <div class="modal-footer">
											 
											<input type="hidden" id="budgetid" name="budgetid" value="<?php echo $col['BudgetId']; ?>" />
											<button type="input" id="submit" name="deletebudget" class="btn btn-primary"><?php echo $Yes; ?></button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $Cancel; ?></button>
                                            </form>
                                        </div>
                                       
                                       
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
							
							<!-- /.edit budget -->
					<div class="modal fade" id="EditBudget<?php echo $col['BudgetId'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
                                <div class="modal-dialog">
                                    <div class="modal-content">
									<form action="" method="post">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"><?php echo $EditThisBudget; ?></h4>
                                        </div>
                                        <div class="modal-body">
												<div class="form-group">
													<label for="editamount" class="control-label"><?php echo $Amount; ?></label> 
													<div class="input-group">
												 <span class="input-group-addon"><?php echo $ColUser['Currency'];?></span>                                      
												 <input class="form-control" required   id="iamount" name="amountedit" type="text" value="<?php echo number_format($col['Amount']); ?>">
											 </div>
											</div>
                                        </div>
                                        <div class="modal-footer">
											 
											<input type="hidden" id="budgetsids" name="budgetsids" value="<?php echo $col['BudgetId']; ?>" />
											<button type="input" id="submit" name="edit" class="btn btn-primary"><?php echo $Save; ?></button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $Cancel; ?></button>
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
			                    <th class="text-left"><?php echo $Category; ?></th>
			                    <th class="text-left"><?php echo $Date; ?></th>
			                    <th class="text-left"><?php echo $Amounts; ?></th>
			                    <th class="text-left"><?php echo $Action; ?></th> 
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
            </div>
        </div>
        <!-- /#page-wrapper -->
   

<div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">  
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <form action="" method="post">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"><?php echo $BudgetFor; ?> <b><?php echo date("F Y");?></h4>
                                        </div>
                                        <div class="modal-body">
                                                 <fieldset>
                                    <div class="form-group col-lg-6 ">
                                        <label for="category"><?php echo $BudgetForCategory; ?></label>
                                        <select name="category" class="form-control">
                                           <?php while($col = mysqli_fetch_assoc($expense)){ ?>
                                            <option value="<?php echo $col['CategoryId'];?>"><?php echo $col['CategoryName'];?></option>
                                            <?php } ?>
                                          </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                         <label for="mount" class="control-label"><?php echo $Amounts; ?></label> 
                                             <div class="input-group">
                                                 <span class="input-group-addon"><?php echo $ColUser['Currency'];?></span>                                      
                                                 <input class="form-control" required placeholder="<?php echo $Amount; ?>"  id="iamount" name="amount" type="text" value="">
                                             </div>
                                   </div>  
                                </fieldset>
                                        </div>
                                        <div class="modal-footer">
                                             
                                            <button type="submit" name="submit" class="btn btn-success"><span class=""></span>  <?php echo $Save; ?></button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $Cancel; ?></button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>


<script>

$(document).on('keyup', '#iamount', function() {
    var x = $(this).val();
    $(this).val(x.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
});


   
    </script>
