<?php
include ('includes/notification.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
  <title>Money Manager</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="css/plugins/dataTables.bootstrap.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="js/plugins/fullcalender/fullcalendar.css" rel="stylesheet">
     <!-- Datepicker CSS -->
     <link href="css/datepicker.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

     <script src="js/jquery-1.11.0.js"></script>
     <script src="js/plugins/metisMenu/metisMenu.js"></script>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="headmain">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Money Manager</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li>
                     <?php 
                    echo $Welcome;?>, 
                    <?php 
                    echo $ColUser['FirstName'];?>
                </li>
                
               
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        
                        <li> <a <?php ActiveClass("index.php?page=Settings");?> href="index.php?page=Settings"><i class="fa fa-gear fa-fw"></i> <?php echo $Settings;?></a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="index.php?action=logout"><i class="fa fa-sign-out fa-fw"></i> <?php echo $Logout;?></a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
        </div>
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav font-sidebar" id="side-menu">
                      
                        <li>
                            <a <?php ActiveClass("index");?> href="index.php" style="color:red"><i class="glyphicon glyphicon-home" style="color:red"></i>  <?php echo $Dashboard;?><span class="fa arrow"><cc/a>
                        </li>
                        <li>
                            <a <?php ActiveClass("index.php?page=Transaction");?>  href="index.php?page=Transaction" style="color:red"><i class="glyphicon glyphicon-refresh" style="color:red"></i>  <?php echo $Transaction;?><span class="fa arrow"></a>
                        </li>
                        <li>
                            <a <?php ActiveClass("index.php?page=AssetReport");?> href="index.php?page=AssetReport"><i class="glyphicon glyphicon-stats"></i>  <?php echo $Incomes;?><span class="fa arrow"></span></a>
                        </li>
                        <li>
                            <a <?php ActiveClass("index.php?page=ExpenseReport");?> href="index.php?page=ExpenseReport" ><i class="glyphicon glyphicon-list-alt"></i> <?php echo $Expenses;?><span class="fa arrow"></span></a>
                        <li>    
                                
                                <li>
                                    <a <?php ActiveClass("index.php?page=ManageAccount");?> href="index.php?page=ManageAccount"> <i class="fa fa-tags"></i> <?php echo $Account;?><span class="fa arrow"></a>
                                </li>
                         
                            <!-- /.nav-second-level -->
                    

                                    
                        </li>                           
                        </li>
                        <li><a <?php ActiveClass("index.php?page=ManageBudget");?> href="index.php?page=ManageBudget"><i class="fa fa-archive"></i> <?php echo $BudgetsM;?><span class="fa arrow"></a>
                        </li>
                        
                    <li>
                        <a class="parent" href="javascript:void(0)"><i class="fa fa-gears"> </i> <?php echo $Settings;?><span class="fa arrow"></a>
                        <ul class="nav nav-second-level" id="subitem">
                                <li>
                                    <a <?php ActiveClass("index.php?page=ManageExpenseCategory");?> href="index.php?page=ManageExpenseCategory"><i class="fa fa-caret-right"></i> <?php echo $CategoryExpense;?></a>
                                </li>
                                <li>
                                    <a <?php ActiveClass("index.php?page=ManageIncomeCategory");?> href="index.php?page=ManageIncomeCategory"><i class="fa fa-caret-right"></i> <?php echo $CategoryIncome;?></a>
                                </li>
                                
                        </ul>
                    </li>

                    <li>
                         <a class="parent" href="javascript:void(0)"><i class="fa fa-print"> </i> <?php echo $ReportsGraphs;?><span class="fa arrow"></a>
                         <ul class="nav nav-second-level" >
                                <li>
                                    <a <?php ActiveClass("index.php?page=IncomeVsExpense");?> id="subitem" href="index.php?page=IncomeVsExpense"><i class="fa fa-caret-right"> </i> <?php echo $IncomeVsExpense;?></a>
                                </li>
                                <li>
                                    <a <?php ActiveClass("index.php?page=IncomeCalender");?> id="subitem" href="index.php?page=IncomeCalender"><i class="fa fa-caret-right"> </i> <?php echo $IncomeCalender;?></a>
                                </li>
                                <li>
                                    <a <?php ActiveClass("index.php?page=ExpenseCalender");?> id="subitem" href="index.php?page=ExpenseCalender"><i class="fa fa-caret-right"> </i> <?php echo $ExpenseCalender;?></a>
                                </li>
                                <li>
                                    <a <?php ActiveClass("index.php?page=AllIncomeReports");?> id="subitem" href="index.php?page=AllIncomeReports"><i class="fa fa-caret-right"></i> <?php echo $IncomeReportsM ;?></a>
                                </li>
                                <li>
                                    <a <?php ActiveClass("index.php?page=AllExpenseReports");?> id="subitem" href="index.php?page=AllExpenseReports"><i class="fa fa-caret-right"></i> <?php echo $ExpenseReportsM;?></a>
                                </li>
                                
                        </ul>
                    </li> 
                       <li>
                            <a <?php ActiveClass("index.php?page=Settings");?> href="index.php?page=Settings"><i class="fa fa-user"> </i> <?php echo $ProfileSettings;?><span class="fa arrow"></a>
                        </li>
                        
                         <li>
                            <a href="index.php?action=logout"><i class="glyphicon glyphicon-log-out"></i>  <?php echo $Logout;?><span class="fa arrow"></a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

<script>

$(document).ready(function () {
    $(this).parent().addClass("collapse");
    $(".parent").on('click', function () {
        $(this).parent().find("#subitem").slideToggle();
    });
});

</script>
      
