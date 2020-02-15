<?php

//Include Functions
include('includes/Functions.php');

//Include Notifications
include ('includes/notification.php');




//Include Global page
	include ('includes/global.php');

// Get all  Income
$GetAllIncomeOverall    = "SELECT SUM(Amount) AS Amount FROM assets WHERE UserId = $UserId" ;
$GetAIncomeOverall      = mysqli_query($mysqli, $GetAllIncomeOverall);
$IncomeColOverall       = mysqli_fetch_assoc($GetAIncomeOverall);
$IncomeOverall          = $IncomeColOverall['Amount'];
	
// Get all by month Income
$GetAllIncomeDate    = "SELECT SUM(Amount) AS Amount FROM assets WHERE UserId = $UserId AND MONTH(Date) = MONTH (CURRENT_DATE())";
$GetAIncomeDate      = mysqli_query($mysqli, $GetAllIncomeDate);
$IncomeColDate       = mysqli_fetch_assoc($GetAIncomeDate);
$IncomeThisMonth     = $IncomeColDate['Amount'];

// Get all by today Income
$GetAllIncomeDateToday       = "SELECT SUM(Amount) AS Amount FROM assets WHERE UserId = $UserId AND Date = CURRENT_DATE()";
$GetAIncomeDateToday         = mysqli_query($mysqli, $GetAllIncomeDateToday);
$IncomeColDateToday          = mysqli_fetch_assoc($GetAIncomeDateToday);
$IncomeToday                 = $IncomeColDateToday['Amount'];

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
$BillToday              	= $BillsColDateToday['Amount'];
?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo $IncomeVsExpense; ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
            <div class="row">
				 
                
               
                <div class="col-lg-4">
                    <div class="panel panel-success ">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> <?php echo $OverallReport; ?>
                        </div>
                        <div class="panel-body">
                            <p class="btn btn-primary"><?php echo $ReportTotalIncome; ?> <?php echo $ColUser['Currency'].' '.number_format($IncomeOverall);?></p><br/><br/>
                            <p class="btn btn-warning"><?php echo $ReportTotalExpense;?> <?php echo $ColUser['Currency'].' '.number_format($BillsOverall);?></p>
                            <hr>
                            <p class="btn btn-danger"><?php echo $ReportIncomeExpense;?> <?php echo $ColUser['Currency'].' '.number_format($IncomeOverall - $BillsOverall);?> </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-success ">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> <?php echo $ReportByMonth; ?>
                        </div>
                        <div class="panel-body">
                            <p class="btn btn-primary"><?php echo $ReportTotalIncome; ?> <?php echo $ColUser['Currency'].' '.number_format($IncomeThisMonth);?></p><br/><br/>
                            <p class="btn btn-warning"><?php echo $ReportTotalExpense;?> <?php echo $ColUser['Currency'].' '.number_format($BillThisMonth);?></p>
                            <hr>
                            <p class="btn btn-danger"><?php echo $ReportIncomeExpense;?> <?php echo $ColUser['Currency'].' '.number_format($IncomeThisMonth - $BillThisMonth);?> </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="panel panel-success ">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> <?php echo $ReportByDay; ?>
                        </div>
                        <div class="panel-body">
                            <p class="btn btn-primary"><?php echo $ReportTotalIncome; ?> <?php echo $ColUser['Currency'].' '.number_format($IncomeToday);?></p><br/><br/>
                            <p class="btn btn-warning"><?php echo $ReportTotalExpense;?> <?php echo $ColUser['Currency'].' '.number_format($BillToday);?></p>
                            <hr>
                            <p class="btn btn-danger"><?php echo $ReportIncomeExpense;?> <?php echo $ColUser['Currency'].' '.number_format($IncomeToday - $BillToday);?> </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <!-- /.panel -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> <?php echo $OverallReport; ?>
                        </div>
                        <div class="panel-body">
                            <div id="morris-donut-chart"></div>  
                        </div>
                    </div>
                </div>
                 <div class="col-lg-6">
                    <!-- /.panel -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> <?php echo $ReportByMonth; ?>
                        </div>
                        <div class="panel-body">
                            <div id="bymonth"></div>  
                        </div>
                    </div>
                </div>
                 
            <!-- /.row -->
            <div class="row">

            </div>
           </div>
        </div>
        <!-- /#page-wrapper -->
   
<script>


    $(function() {
		
		$('#calendar').fullCalendar({
			header:{
					left: 'prev,next today',
					center: 'title',
					right: 'month, agendaWeek,agendaDay'
				},
			allDayDefault: true,
			editable: false,
			backgroundColor : '#428bca',
			events:{
					url:'includes/get-daily.php',
					error: function(){
							alert('there was an error while fetching events!');
						
						},
				},		
		eventRender: function(event, element) {
				element.find(".fc-content").remove();
				element.find(".fc-event-time").remove();
				var new_description =   
						event.title + '<br/>'
						+  event.names + '<br/>';
						element.append(new_description);
				},
				
			loading: function(bool){
					$('#loading').toggle(bool);
					
				}		
			
			});
			
			$('#expense-calendar').fullCalendar({
			header:{
					left: 'prev,next today',
					center: 'title',
					right: 'month, agendaWeek,agendaDay'
				},
			allDayDefault: true,
			editable: false,
			backgroundColor : '#428bca',
			events:{
					url:'includes/get-expense-daily.php',
					error: function(){
							alert('there was an error while fetching events!');
						
						},
				},		
		eventRender: function(event, element) {
				element.find(".fc-content").remove();
				element.find(".fc-event-time").remove();
				var new_description =   
						event.title + '<br/>'
						+  event.names + '<br/>';
						element.append(new_description);
				},
				
			loading: function(bool){
					$('#loading').toggle(bool);
					
				}		
			
			});
		
		
		
		Morris.Donut({
        element: 'morris-donut-chart',
        data: [
			
			
            {
            label: "<?php echo $Incomes .' '. $ColUser['Currency'];?>",
            value: <?php echo $IncomeOverall ;?>
            },
            {
            label: "<?php echo $Expenses .' '. $ColUser['Currency'];?>",
            value: <?php echo  $BillsOverall;?>
            },	
       ],
        resize: true
    });

        Morris.Donut({
        element: 'bymonth',
        data: [
            
            
            {
            label: "<?php echo $Incomes .' '. $ColUser['Currency'];?>",
            value: <?php echo $IncomeThisMonth ;?>
            },
            {
            label: "<?php echo $Expenses .' '. $ColUser['Currency'];?>",
            value: <?php echo  $BillThisMonth;?>
            },  
       ],
        resize: true
    });

     
    

     $('.notification').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })

    });
    </script>
