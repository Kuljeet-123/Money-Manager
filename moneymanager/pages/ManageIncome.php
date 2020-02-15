<?php

$msgBox='';
//Include Functions
include('includes/Functions.php');

//Include Notifications
include ('includes/notification.php');

//Get id income to manage
if(isset($_GET['id'])){
$IncomeId = abs($_GET['id']);

//Select income form to edit
if($IncomeId != ''){
		$EditIncome = "SELECT a.AssetsId, a.Title, a.Date, a.Amount, a.Description, c.CategoryName, c.CategoryId, ac.AccountId, ac.AccountName from assets a, category c, account ac where a.CategoryId = c.CategoryId 
					AND a.AccountId = ac.AccountId AND c.Level = 1 AND a.UserId = $UserId AND a.AssetsId = $IncomeId";
		if($IncomeEdit = mysqli_query($mysqli,$EditIncome)){
			$row = mysqli_fetch_assoc($IncomeEdit);
		}
	}
}
	else{exit;}
	

// Update new Income
if(isset($_POST['income'])){
		$IncomeId		= $row['AssetsId'];
		$iuser			= $_SESSION['UserId'];
		$iname 			= $mysqli->real_escape_string($_POST["iname"]);
		$icategory		= $mysqli->real_escape_string($_POST["icategory"]);
		$iaccount		= $mysqli->real_escape_string($_POST["iaccount"]);
		$idescription	= $mysqli->real_escape_string($_POST["idescription"]);
		$idate			= $mysqli->real_escape_string($_POST["idate"]);
		$iamount		= $mysqli->real_escape_string(clean($_POST["iamount"]));
		
		
		$sql="UPDATE assets SET Title = ?, Date = ?, CategoryId = ?, AccountId = ?, Amount = ?, Description = ? WHERE AssetsId = $IncomeId";
		if($statement = $mysqli->prepare($sql)){
			//bind parameters for markers, where (s = string, i = integer, d = double,  b = blob)
			$statement->bind_param('ssiiss', $iname, $idate, $icategory, $iaccount, $iamount, $idescription);	
			$statement->execute();
			
		}
		$msgBox = alertBox($UpdateMsgIncome);
	}	
	
// Get new data after update	
$EditIncome = "SELECT a.AssetsId, a.Title, a.Date, a.Amount, a.Description, c.CategoryName, c.CategoryId, ac.AccountId, ac.AccountName from assets a, category c, account ac where a.CategoryId = c.CategoryId 
					AND a.AccountId = ac.AccountId AND c.Level = 1 AND a.UserId = $UserId AND a.AssetsId = $IncomeId";
		if($IncomeEdit = mysqli_query($mysqli,$EditIncome)){
			$row = mysqli_fetch_assoc($IncomeEdit);
		}	
	
?>        
        
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
				    <h1 class="page-header"><?php echo $ManageIncome ; ?></h1>
                </div>
            </div>
            <div class="row">

                  <div class="col-lg-12 ">
					  <?php if ($msgBox) { echo $msgBox; } ?>
		            <div class="panel panel-primary">
                        <div class="panel-heading">
                           <i class="fa fa-plus"></i> <?php echo $Incomes ; ?>
                        </div>
                            <div class="panel-body">
                                <form role="form" method="post" action="">
                                    <fieldset>
                                    <div class="form-group col-lg-6">
								        <label for="iname"><?php echo $Name ; ?></label>
                                        <input class="form-control" required placeholder="<?php echo $Name ; ?>" value="<?php echo $row['Title'];?> " name="iname" type="text" autofocus>
                                    </div>
                                    
                                    <div class="form-group col-lg-6">
										 <label for="iamount" class="control-label"><?php echo $Amount ; ?></label> 
											 <div class="input-group">
												 <span class="input-group-addon"><?php echo $ColUser['Currency'];?></span>                                      
												 <input class="form-control" required placeholder="<?php echo $Amount ; ?>" value="<?php echo number_format($row['Amount']);?>" id="iamount" name="iamount" type="text" value="">
											 </div>
                                   </div>
                                   <div class="form-group col-lg-6">
                                        <label for="icategory"><?php echo $Category ; ?></label>
                                        <select name="icategory" class="form-control">
											<option value="<?php echo $row['CategoryId'];?>" select="selected"><?php echo $row['CategoryName'];?></option>
											<option value="" disabled>------------------</option>
										<?php while($col = mysqli_fetch_assoc($income)){ ?>
                                            <option value="<?php echo $col['CategoryId'];?>"><?php echo $col['CategoryName'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                                                     
                                   <div class="form-group col-lg-6">
                                         <label for="iaccount"><?php echo $Account ; ?></label>
                                        <select name="iaccount" class="form-control">
											<option value="<?php echo $row['AccountId'];?>" select="selected"><?php echo $row['AccountName'];?></option>
											<option value="" disabled>------------------</option>
                                            <?php while($col = mysqli_fetch_assoc($AccountIncome)){ ?>
                                            <option value="<?php echo $col['AccountId'];?>"><?php echo $col['AccountName'];?></option>
                                            <?php } ?>
                                        </select>
                                   </div>
                                   <div class="form-group col-lg-6" id="income">
                                         <label for="idate"><?php echo $Date ; ?></label>
                                        <div class="input-group date">
											<input name="idate" class="form-control" type="text"  value="<?php echo $row['Date'];?>">
											<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
										</div>
                                   </div>
                                     <div class="form-group col-lg-6 ">
                                         <label for="idescription"><?php echo $Description ; ?></label>
                                        <textarea name="idescription" class="form-control"><?php echo $row['Description'];?></textarea>
                                   </div>                             
                                </fieldset>
                                <div class="form-group col-lg-3 col-md-6">
                               <button type="submit" name="income" class="btn btn-success btn-block "><span class="glyphicon glyphicon-log-in"></span>  <?php echo $SaveIncome ; ?></button>
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

