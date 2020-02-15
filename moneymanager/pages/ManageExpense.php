<?php

$msgBox='';
//Include Functions
include('includes/Functions.php');

//Include Notifications
include ('includes/notification.php');

//Get id expense to manage
if(isset($_GET['id'])){
$ExpenseId = abs($_GET['id']);

//Select expense form to edit
if($ExpenseId != ''){
		$EditExpense = "SELECT a.BillsId, a.Title, a.Dates, a.Amount, a.Description, c.CategoryName, c.CategoryId, ac.AccountId, ac.AccountName from bills a, category c, account ac where a.CategoryId = c.CategoryId 
					AND a.AccountId = ac.AccountId AND c.Level = 2 AND a.UserId = $UserId AND a.BillsId = $ExpenseId";
		if($ExpenseEdit = mysqli_query($mysqli,$EditExpense)){
			$row = mysqli_fetch_assoc($ExpenseEdit);
		}
	}
}
	else{exit;}
	

// Update new expense
if(isset($_POST['expense'])){
		$ExpenseId		= $row['BillsId'];
		$iuser			= $_SESSION['UserId'];
		$iname 			= $mysqli->real_escape_string($_POST["iname"]);
		$icategory		= $mysqli->real_escape_string($_POST["icategory"]);
		$iaccount		= $mysqli->real_escape_string($_POST["iaccount"]);
		$idescription	= $mysqli->real_escape_string($_POST["idescription"]);
		$idate			= $mysqli->real_escape_string($_POST["idate"]);
		$iamount		= $mysqli->real_escape_string(clean($_POST["iamount"]));
		
		
		$sql="UPDATE bills SET Title = ?, Dates = ?, CategoryId = ?, AccountId = ?, Amount = ?, Description = ? WHERE BillsId = $ExpenseId";
		if($statement = $mysqli->prepare($sql)){
			//bind parameters for markers, where (s = string, i = integer, d = double,  b = blob)
			$statement->bind_param('ssiiss', $iname, $idate, $icategory, $iaccount, $iamount, $idescription);	
			$statement->execute();
			
		}
		$msgBox = alertBox($UpdateMsgExpense);
	}	
	
// Get new data after update	
$EditExpense = "SELECT a.BillsId, a.Title, a.Dates, a.Amount, a.Description, c.CategoryName, c.CategoryId, ac.AccountId, ac.AccountName from bills a, category c, account ac where a.CategoryId = c.CategoryId 
					AND a.AccountId = ac.AccountId AND c.Level = 2 AND a.UserId = $UserId AND a.BillsId = $ExpenseId";
		if($ExpenseEdit = mysqli_query($mysqli,$EditExpense)){
			$row = mysqli_fetch_assoc($ExpenseEdit);
		}
	
?>        
        
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
				    <h1 class="page-header"><?php echo $ManageExpense ;?></h1>
                </div>
            </div>
            <div class="row">

                  <div class="col-lg-12">
					  <?php if ($msgBox) { echo $msgBox; } ?>
		            <div class="panel panel-danger">
                        <div class="panel-heading">
                           <i class="fa fa-minus"></i> <?php echo $Expenses ;?>
                        </div>
                            <div class="panel-body">
                                <form role="form" method="post" action="">
                                    <fieldset>
                                    <div class="form-group col-lg-6">
								        <label for="iname"><?php echo $Name ;?></label>
                                        <input class="form-control" required placeholder="<?php echo $Name ;?>" value="<?php echo $row['Title'];?> " name="iname" type="text" autofocus>
                                    </div>
                                    
                                    <div class="form-group col-lg-6">
										 <label for="iamount" class="control-label"><?php echo $Amount ;?></label> 
											 <div class="input-group">
												 <span class="input-group-addon"><?php echo $ColUser['Currency'];?></span>                                      
												 <input class="form-control" required placeholder="<?php echo $Amount ;?>" value="<?php echo number_format($row['Amount']);?>" id="iamount" name="iamount" type="text" value="">
											 </div>
                                   </div>
                                   <div class="form-group col-lg-6">
                                        <label for="icategory"><?php echo $Category ;?></label>
                                        <select name="icategory" class="form-control">
											<option value="<?php echo $row['CategoryId'];?>" select="selected"><?php echo $row['CategoryName'];?></option>
											<option value="" disabled>------------------</option>
										<?php while($col = mysqli_fetch_assoc($expense)){ ?>
                                            <option value="<?php echo $col['CategoryId'];?>"><?php echo $col['CategoryName'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                                                     
                                   <div class="form-group col-lg-6">
                                         <label for="iaccount"><?php echo $Account ;?></label>
                                        <select name="iaccount" class="form-control">
											<option value="<?php echo $row['AccountId'];?>" select="selected"><?php echo $row['AccountName'];?></option>
											<option value="" disabled>------------------</option>
                                            <?php while($col = mysqli_fetch_assoc($AccountIncome)){ ?>
                                            <option value="<?php echo $col['AccountId'];?>"><?php echo $col['AccountName'];?></option>
                                            <?php } ?>
                                        </select>
                                   </div>
                                   <div class="form-group col-lg-6" id="income">
                                         <label for="idate"><?php echo $Date ;?></label>
                                        <div class="input-group date">
											<input name="idate" class="form-control" type="text"  value="<?php echo $row['Dates'];?>">
											<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
										</div>
                                   </div>
                                     <div class="form-group col-lg-6 ">
                                         <label for="idescription"><?php echo $Description ;?></label>
                                        <textarea name="idescription" class="form-control"><?php echo $row['Description'];?></textarea>
                                   </div>                             
                                </fieldset>
                                <div class="form-group col-lg-3 col-md-6">
                               <button type="submit" name="expense" class="btn btn-warning btn-block "><span class="glyphicon glyphicon-log-in"></span>  <?php echo $SaveExpense ;?></button>
								</div>
								</form>
                            </div>
                         </div>
                    </div>
                 </div>
            </div>
        </div>
 <script>
$(document).on('keyup', '#iamount', function() {
    var x = $(this).val();
    $(this).val(x.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
});
 </script>

