<?php 
session_start();
$UserId=$_SESSION['UserId'];

//include db and tcpdf plugin
require_once('../includes/notification.php');
require_once('../includes/db.php');
require_once('../includes/plugin/tcpdf/tcpdf.php');

//Get userinfo

$GetUserInfo = "SELECT * FROM user WHERE UserId = $UserId";
$UserInfo = mysqli_query($mysqli, $GetUserInfo);
$ColUser = mysqli_fetch_assoc($UserInfo);


//Get Report Expense History
$GetExpenseHistory = "SELECT * from bills left join category on bills.CategoryId = category.CategoryId left join account on bills.AccountId = account.AccountId where bills.UserId = $UserId ORDER BY bills.Dates DESC";
$ExpenseReport = mysqli_query($mysqli,$GetExpenseHistory); 


// Filter Report Expense

	$SearchTerm = $_GET['filter'];
	$GetExpenseHistory = "SELECT * from bills left join category on bills.CategoryId = category.CategoryId left join account on bills.AccountId = account.AccountId where 
					(bills.Title like '%$SearchTerm%' 
					OR account.AccountName like '%$SearchTerm%'
					OR bills.Description like '%$SearchTerm%' 
					OR category.CategoryName like '%$SearchTerm%')
					AND bills.UserId = $UserId ORDER BY bills.Dates DESC";
$ExpenseReport = mysqli_query($mysqli,$GetExpenseHistory); 
	




// Set PDF TCPDF
$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
	// set document information
	$pdf->SetCreator('Money Manager');
	$pdf->SetTitle('Expense Report');

	// set default header data
	$pdf->SetHeaderData('logo.gif', '20', 'Your Company Name', 'Expense Report', array(0,64,255), array(0,64,128));
	$pdf->setFooterData(array(0,64,0), array(0,64,128));

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$pdf->SetTopMargin(35);
	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


	// ---------------------------------------------------------
	//convert to PDF


	$pdf->SetFont('dejavusans', '', 9, '', true);
	$pdf->AddPage('L','A4');

	// set text shadow effect
	$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

	$tbl_header = '<table align="center" border="1">';
	$thead='<thead align="center">						<tr>
														<td style="margin-bottom:12px;font-weight:bold;width:200px;">'.$Title.'</td>
														<td style="margin-bottom:12px;font-weight:bold;width:100px;">'.$Date.'</td>
														<td style="margin-bottom:12px;font-weight:bold;width:150px;">'.$Category.'</td>
														<td style="margin-bottom:12px;font-weight:bold;width:150px;">'.$Account.'</td>
														<td style="margin-bottom:12px;font-weight:bold;width:250px;">'.$Description.'</td>
														<td style="margin-bottom:12px;font-weight:bold;width:100px;">'.$Amount.'</td>
			</thead>
														</tr>';
	$tbl_footer = '</table>';
	
	$tbl =''; 
	$ok = '';
	$Sum=0;
	 while($col = mysqli_fetch_assoc($ExpenseReport))
			{
			$Title=$col['Title'];
			$Date=date("M d Y",strtotime($col['Dates']));
			$CategoryName=$col['CategoryName'];
			$AccountName=$col['AccountName'];
			$Description=$col['Description'];
			$Amount=$ColUser['Currency'].' '.number_format($col['Amount']);
			$Sum += $col['Amount'];
			
			$tbl .= '<tr><td style="text-align:left;margin-bottom:12px;font-weight:bold;width:200px;">' .$Title . '</td><td style="padding-left:12px;text-align:left;width:100px;">' . $Date . '</td><td style="margin-bottom:12px;width:150px;">' . $CategoryName . '</td><td style="margin-bottom:12px;width:150px;">' . $AccountName . '</td><td style="margin-bottom:12px;width:250px;">' . $Description . '</td><td style="margin-bottom:12px;width:100px;">' . $Amount . '</td></tr>';
			
			$ok= '<h4 style="text-align:right;font-weight:bold;">'.$TotalExpenseReport.$ColUser['Currency'].' '.number_format($Sum). '</h4>'; 
			}

	$pdf->writeHTML($tbl_header . $thead . $tbl . $tbl_footer . $ok , true, false, false, false, '');

	$pdf->Output('Expense_Report.pdf', 'D');
	 
	 
?>
