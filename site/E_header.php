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
<script type="text/javascript">
$(document).ready(function() {
	$('a.login-window').click(function() {
		
		// Getting the variable's value from a link 
		var loginBox = $(this).attr('href');

		//Fade in the Popup and add close button
		$(loginBox).fadeIn(300);
		
		//Set the center alignment padding + border
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;
	});
	
	// When clicking on the button close or the mask layer the popup closed
	$('a.close, #mask').live('click', function() { 
	  $('#mask , .login-popup').fadeOut(300 , function() {
		$('#mask').remove();  
	}); 
	return false;
	});
});
</script>


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
					<span style="font-size:15px;font-weight:700;padding-right:20px;line-height:40px;">Follow us on</span>
					<a href="#"><img src="images/fbuk.png" alt="facebook share" title="Facebook"/></a>
					<a href="#"><img src="images/tweet.png" alt="Twitter share"/ title="Twitter"></a>
					<a href="#"><img src="images/gplus.png" alt="Google Plus share" title="Mail"/></a>

			</div>
		</div>
		<nav>
		<div id="menu_wrapper" class="blue">
		<div class="left"></div>
			<ul id="menu">
				<li <?php if($_GET['id']==1){echo 'class="active"';}?>><a href="index.php?id=1" ><span><span>Home</span></span></a></li>
				<li <?php if($_GET['id']==2){echo 'class="active"';}?>><a href="About.php?id=2"><span><span>About Us</span></span></a></li>
				<li <?php if($_GET['id']==3){echo 'class="active"';}?>><a href="Projects.php?id=3"><span><span>How to play</span></span></a></li>
				<li <?php if($_GET['id']==4){echo 'class="active"';}?>><a href="Contacts.php?id=4"><span><span>Hall of fame</span></span></a></li>
				<li <?php if($_GET['id']==5){echo 'class="active"';}?>><a href="Sitemap.php?id=5"><span><span>Contact Us</span></span></a></li>
				<li class="special"><a href="#login-box" class="login-window"><span><span>Sign in</span></span></a></li>
			</ul>
		</div>

		<div id="login-box" class="login-popup">
       			 <a href="#" class="close"><img src="images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
         			 <form method="post" class="signin" action="#">
             				   <fieldset class="textbox">
            					<label class="username">
               						 <span>Usename or Email</span>
                					 <input id="username" name="username" value="" type="text" autocomplete="on" placeholder="Username" >
               					</label>

                				<label class="password">
                					<span>Password</span>
                					<input id="password" name="password" value="" type="password" placeholder="Password" />
               					</label>
						<br/>
                				<p style="text-align:center">
                				<input id="submit_button" type="submit" value="Sign in"/>
                				<input id="submit_button" type="submit" value="Join Now" style="margin-left:10px;background:#E56717;border:#3000a2;;"/>
						<br/>
                					<a class="forgot" href="Sitemap.php">Forgot your password?</a><br/>
                				</p>
                
                			  </fieldset>
          			</form>
		</div>


		</nav>
		<div class="wrapper">
			<div class="text">
				<span class="text1"><!--Effective -->
					<span>
						" Success in the stock market usually comes to those who are too busy to be looking for it. "
						
						<span style="text-align:right;margin-top:10px;font-size:25px;color:#3490a5">
						  -- Henry Thoreau 
						</span>
					</span>
					
				</span>
				<!-- <a href="#" class="button">read more</a> -->
			</div>
		</div>
	</header>
<!-- / header -->
