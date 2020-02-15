<?php


$msgBox = '';


//include notification page
include('includes/notification.php');

//Include Function page
include('includes/Functions.php');

include('includes/db.php');

//User Signup
if(isset($_POST['signup'])){
	if($_POST['email'] == '' || $_POST['firstname'] == '' || $_POST['lastname'] == '' || $_POST['password'] == '' || $_POST['rpassword'] == '') {
				$msgBox = alertBox($SignUpEmpty);
			} else if($_POST['password'] != $_POST['rpassword']) {
				$msgBox = alertBox($PwdNotSame);
				
			} else {
				// Set new account
				$Email 		= $mysqli->real_escape_string($_POST['email']);
				$Password 	= encryptIt($_POST['password']);
				$FirstName	= $mysqli->real_escape_string($_POST['firstname']);
				$LastName	= $mysqli->real_escape_string($_POST['lastname']);
				$Currency	= $mysqli->real_escape_string($_POST['currency']);
				
				//Check if already register

				$sql="Select Email from user Where Email = '$Email'";

				 $c= mysqli_query($mysqli, $sql);

                    if (mysqli_num_rows($c) >= 1) {

                        $msgBox = alertBox($AlreadyRegister);
                    }
                    else{

				// add new account
				$sql="INSERT INTO user (FirstName, LastName, Email, Password, Currency) VALUES (?,?,?,?,?)";
				if($statement = $mysqli->prepare($sql)){
					//bind parameters for markers, where (s = string, i = integer, d = double,  b = blob)
					$statement->bind_param('sssss', $FirstName, $LastName, $Email, $Password, $Currency);	
					$statement->execute();
				}
				$msgBox = alertBox($SuccessAccount);
				}
			}
}

?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Money Manager Sign Up</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/custom.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="login-panel panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"><span class="glyphicon glyphicon-lock"></span> <?php  echo $CreateAnAccount; ?></h3>
                    </div>
                    <div class="panel-body">
						<?php if ($msgBox) { echo $msgBox; } ?>
                        <form method="post" action="" role="form">
                            <fieldset>
                                <div class="form-group col-lg-6">
                                    <label for="email"><?php  echo $Emails; ?></label>
                                    <input class="form-control"  placeholder="<?php  echo $Emails; ?>" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="email"><?php  echo $FirstNames; ?></label>
                                    <input class="form-control"  placeholder="<?php  echo $FirstNames; ?>" name="firstname" type="text" >
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="email"><?php  echo $LastNames; ?></label>
                                    <input class="form-control"  placeholder="<?php  echo $LastNames; ?>" name="lastname" type="text" >
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="email"><?php  echo $Currencys; ?></label>
                                    <select class="form-control bold"  name="currency">
										<option value="د.إ">Arab Emirates Dirham (AED)</option>
										<option value="؋">Afghan Afghani (AFN)</option>
										<option value="Lek">Albanian Lek (ALL)</option>
										<option value="AMD">Armenian Dram (AMD)</option>
										<option value="ANG">Neth. Antillean Guilder (ANG)</option>
										<option value="Kz">Angolan Kwanza (AOA)</option>
										<option value="$">Argentine Peso (ARS)</option>
										<option value="A$">Australian Dollar (A$)</option>
										<option value="AWG">Aruban Florin (AWG)</option>
										<option value="ман">Azerbaijani Manat (AZN)</option>
										<option value="KM">Bosnia-Her. Convertible Mark (BAM)</option>
										<option value="">Barbadian Dollar (BBD)</option>
										<option value="Tk">Bangladeshi Taka (BDT)</option>
										<option value="лв">Bulgarian Lev (BGN)</option>
										<option value="BD">Bahraini Dinar (BHD)</option>
										<option value="BIF">Burundian Franc (BIF)</option>
										<option value="BMD">Bermudan Dollar (BMD)</option>
										<option value="$">Brunei Dollar (BND)</option>
										<option value="$b">Bolivian Boliviano (BOB)</option>
										<option value="R$">Brazilian Real (R$)</option>
										<option value="BSD">Bahamian Dollar (BSD)</option>
										<option value="BTN">Bhutanese Ngultrum (BTN)</option>
										<option value="BWP">Botswanan Pula (BWP)</option>
										<option value="BYR">Belarusian Ruble (BYR)</option>
										<option value="BZD">Belize Dollar (BZD)</option>
										<option value="CA$">Canadian Dollar (CA$)</option>
										<option value="CDF">Congolese Franc (CDF)</option>
										<option value="CHF">Swiss Franc (CHF)</option>
										<option value="$">Chilean Peso (CLP)</option>
										<option value="¥">Chinese Yuan (CN¥)</option>
										<option value="$">Colombian Peso (COP)</option>
										<option value="₡">Costa Rican Colón (CRC)</option>
										<option value="₱">Cuban Peso (CUP)</option>
										<option value="CVE">Cape Verdean Escudo (CVE)</option>
										<option value="Kč">Czech Republic Koruna (CZK)</option>
										<option value="DEM">German Mark (DEM)</option>
										<option value="DJF">Djiboutian Franc (DJF)</option>
										<option value="kr">Danish Krone (DKK)</option>
										<option value="RD$">Dominican Peso (DOP)</option>
										<option value="DZD">Algerian Dinar (DZD)</option>
										<option value="£">Egyptian Pound (EGP)</option>
										<option value="ERN">Eritrean Nakfa (ERN)</option>
										<option value="ETB">Ethiopian Birr (ETB)</option>
										<option value="€">Euro (€)</option>
										<option value="$">Fijian Dollar (FJD)</option>
										<option value="£">Falkland Islands Pound (FKP)</option>
										<option value="£">British Pound Sterling (₤)</option>
										<option value="GEL">Georgian Lari (GEL)</option>
										<option value="GHS">Ghanaian Cedi (GHS)</option>
										<option value="£">Gibraltar Pound (GIP)</option>
										<option value="GMD">Gambian Dalasi (GMD)</option>
										<option value="GNF">Guinean Franc (GNF)</option>
										<option value="Q">Guatemalan Quetzal (GTQ)</option>
										<option value="$">Guyanaese Dollar (GYD)</option>
										<option value="HK$">Hong Kong Dollar (HK$)</option>
										<option value="L">Honduran Lempira (HNL)</option>
										<option value="kn">Croatian Kuna (HRK)</option>
										<option value="Ft">Hungarian Forint (HUF)</option>
										<option value="HTG">Haitian Gourde (HTG)</option>
										<option value="Rp">Indonesian Rupiah (IDR)</option>
										<option value="₪">Israeli New Sheqel (₪)</option>
										<option value="₹">Indian Rupee (Rs.)</option>
										<option value="IQD">Iraqi Dinar (IQD)</option>
										<option value="﷼">Iranian Rial (IRR)</option>
										<option value="kr">Icelandic Króna (ISK)</option>
										<option value="J$">Jamaican Dollar (JMD)</option>
										<option value="JOD">Jordanian Dinar (JOD)</option>
										<option value="¥">Japanese Yen (¥)</option>
										<option value="KES">Kenyan Shilling (KES)</option>
										<option value="лв">Kyrgystani Som (KGS)</option>
										<option value="៛">Cambodian Riel (KHR)</option>
										<option value="KMF">Comorian Franc (KMF)</option>
										<option value="₩">North Korean Won (KPW)</option>
										<option value="₩">South Korean Won (₩)</option>
										<option value="KWD">Kuwaiti Dinar (KWD)</option>
										<option value="$">Cayman Islands Dollar (KYD)</option>
										<option value="лв">Kazakhstani Tenge (KZT)</option>
										<option value="₭">Laotian Kip (LAK)</option>
										<option value="£">Lebanese Pound (LBP)</option>
										<option value="Rs">Sri Lankan Rupee (LKR)</option>
										<option value="$">Liberian Dollar (LRD)</option>
										<option value="LSL">Lesotho Loti (LSL)</option>
										<option value="LTL">Lithuanian Litas (LTL)</option>
										<option value="LYD">Libyan Dinar (LYD)</option>
										<option value="MAD">Moroccan Dirham (MAD)</option>
										<option value="MDL">Moldovan Leu (MDL)</option>
										<option value="MGA">Malagasy Ariary (MGA)</option>
										<option value="ден">Macedonian Denar (MKD)</option>
										<option value="MMK">Myanmar Kyat (MMK)</option>
										<option value="MNT">Mongolian Tugrik (MNT)</option>
										<option value="MOP">Macanese Pataca (MOP)</option>
										<option value="MRO">Mauritanian Ouguiya (MRO)</option>
										<option value="Rs">Mauritian Rupee (MUR)</option>
										<option value="MVR">Maldivian Rufiyaa (MVR)</option>
										<option value="MWK">Malawian Kwacha (MWK)</option>
										<option value="MX$">Mexican Peso (MX$)</option>
										<option value="MYR">Malaysian Ringgit (MYR)</option>
										<option value="MT">Mozambican Metical (MZN)</option>
										<option value="$">Namibian Dollar (NAD)</option>
										<option value="₦">Nigerian Naira (NGN)</option>
										<option value="C$">Nicaraguan Córdoba (NIO)</option>
										<option value="kr">Norwegian Krone (NOK)</option>
										<option value="₨">Nepalese Rupee (NPR)</option>
										<option value="NZ$">New Zealand Dollar (NZ$)</option>
										<option value="﷼">Omani Rial (OMR)</option>
										<option value="B/.">Panamanian Balboa (PAB)</option>
										<option value="S/.">Peruvian Nuevo Sol (PEN)</option>
										<option value="PGK">Papua New Guinean Kina (PGK)</option>
										<option value="₱">Philippine Peso (Php)</option>
										<option value="Rs">Pakistani Rupee (PKR)</option>
										<option value="zł">Polish Zloty (PLN)</option>
										<option value="Gs">Paraguayan Guarani (PYG)</option>
										<option value="﷼">Qatari Rial (QAR)</option>
										<option value="RON">Romanian Leu (RON)</option>
										<option value="Дин.">Serbian Dinar (RSD)</option>
										<option value="руб">Russian Ruble (RUB)</option>
										<option value="RWF">Rwandan Franc (RWF)</option>
										<option value="﷼">Saudi Riyal (SAR)</option>
										<option value="$">Solomon Islands Dollar (SBD)</option>
										<option value="Rs">Seychellois Rupee (SCR)</option>
										<option value="SDG">Sudanese Pound (SDG)</option>
										<option value="kr">Swedish Krona (SEK)</option>
										<option value="S$">Singapore Dollar (SGD)</option>
										<option value="£">Saint Helena Pound (SHP)</option>
										<option value="SLL">Sierra Leonean Leone (SLL)</option>
										<option value="S">Somali Shilling (SOS)</option>
										<option value="$">Surinamese Dollar (SRD)</option>
										<option value="STD">São Tomé and Príncipe Dobra (STD)</option>
										<option value="$">Salvadoran Colón (SVC)</option>
										<option value="£">Syrian Pound (SYP)</option>
										<option value="SZL">Swazi Lilangeni (SZL)</option>
										<option value="฿">Thai Baht (฿)</option>
										<option value="TJS">Tajikistani Somoni (TJS)</option>
										<option value="TMT">Turkmenistani Manat (TMT)</option>
										<option value="TND">Tunisian Dinar (TND)</option>
										<option value="TOP">Tongan Paʻanga (TOP)</option>
										<option value="TRY">Turkish Lira (TRY)</option>
										<option value="TT$">Trinidad and Tobago Dollar (TTD)</option>
										<option value="NT$">New Taiwan Dollar (NT$)</option>
										<option value="TZS">Tanzanian Shilling (TZS)</option>
										<option value="₴">Ukrainian Hryvnia (UAH)</option>
										<option value="UGX">Ugandan Shilling (UGX)</option>
										<option selected="" value="$">US Dollar ($)</option>
										<option value="$U">Uruguayan Peso (UYU)</option>
										<option value="лв">Uzbekistan Som (UZS)</option>
										<option value="Bs">Venezuelan Bolívar (VEF)</option>
										<option value="₫">Vietnamese Dong (₫)</option>
										<option value="VUV">Vanuatu Vatu (VUV)</option>
										<option value="WST">Samoan Tala (WST)</option>
										<option value="XOF">CFA Franc BCEAO (CFA)</option>
										<option value="EC$">East Caribbean Dollar (EC$)</option>
										<option value="XDR">Special Drawing Rights (XDR)</option>
										<option value="XPF">CFP Franc (CFPF)</option>
										<option value="﷼">Yemeni Rial (YER)</option>
										<option value="S">South African Rand (ZAR)</option>
										<option value="ZMK">Zambian Kwacha (ZMK)</option></select>
									
									</select>
                                </div>
                                <div class="form-group col-lg-6">
                                     <label for="password"><?php  echo $Passwords; ?></label>
                                    <input class="form-control"  placeholder="<?php  echo $Passwords; ?>" name="password" type="password" value="">
                               </div>
                                <div class="form-group col-lg-6">
                                     <label for="password"><?php  echo $RepeatPassword; ?></label>
                                    <input class="form-control"  placeholder="<?php  echo $RepeatPassword; ?>" name="rpassword" type="password" value="">
                               </div>
                               <hr>
                                <button type="submit" name="signup" class="btn btn-success btn-block"><span class="glyphicon glyphicon-log-in"></span>  <?php  echo $Save; ?></button>                                 <hr>
                               
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row text-center">
            
            <small >Powered By Developer Kuljeet Singh</small>
        </div>
    </div>

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>

</body>

</html>
