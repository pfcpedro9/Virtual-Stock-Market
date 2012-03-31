<?php $page_id=1 ;?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>
<?php


switch ($_GET['id'])
{
case 1:
  echo "EquityMaster-Home";
  break;
case 2:
  echo "EquityMaster-About";
  break;
case 3:
  echo "EquityMaster-Projects";
  break;
case 4:
  echo "EquityMaster-Contacts";
  break;
case 5:
  echo "EquityMaster-Sitemap";
  break;
default:
  echo "EquityMaster";
}

?>
</title>
<meta charset="utf-8">

<link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<script type="text/javascript" src="js/jquery-1.4.2.js" ></script>
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/cufon-replace.js"></script>
<script type="text/javascript" src="js/Myriad_Pro_400.font.js"></script>
<script type="text/javascript" src="js/Myriad_Pro_700.font.js"></script>
<script type="text/javascript" src="js/Myriad_Pro_600.font.js"></script>

</head>
<body id="page2">
<div class="main">
<!-- header -->
	<header>
		<div class="wrapper">
			<h1><a href="index.php" id="logo">Smart Biz</a></h1>
		<!--	<form id="search" action="" method="post">
				<div class="bg">
					<input type="submit" class="submit" value="">
					<input type="text" class="input">
				</div>
			</form>
		!-->
			<div class="bg" id="follow">
					<span style="font-size:17px;font-weight:700;padding-right:20px;line-height:40px;">Welcome <span style="color:#308da2;">Administrator</span></span>
				

			</div>
		</div>
		<nav>
		<div id="menu_wrapper" class="blue">
		<div class="left"></div>
			<ul id="menu">
				<li <?php if($_GET['id']==1){echo 'class="active"';}?>><a href="#" ><span><span>Portfolio</span></span></a></li>
				<li <?php if($_GET['id']==2){echo 'class="active"';}?>><a href="#"><span><span>Trade</span></span></a></li>
				<li <?php if($_GET['id']==3){echo 'class="active"';}?>><a href="#"><span><span>Watchlist</span></span></a></li>
				<li <?php if($_GET['id']==4){echo 'class="active"';}?>><a href="#"><span><span>Rank List</span></span></a></li>
				<li <?php if($_GET['id']==5){echo 'class="active"';}?>><a href="#"><span><span>My Account</span></span></a></li>
				<li class="special"><a href="#"><span><span>Logout</span></span></a></li>
			</ul>
		</div>

		

		</nav>
		
	</header>
<!-- / header -->
