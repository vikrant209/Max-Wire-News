<?php 
error_reporting(E_ALL & ~E_NOTICE);
$notLogin = 1;
include_once 'load.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Maxwirenews</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="css/tabcontent.css" />
<script type="text/javascript" src="js/tabcontent.js"></script>
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
/* Back to top scroll */
	$(window).scroll(function(){
		if ($(this).scrollTop() > 100) { $('.scrollup').slideDown(); } else { $('.scrollup').slideUp(); }
	}); 
	$('.scrollup').click(function(){
		$("html, body").animate({ scrollTop: 0 }, 2000, 'easeInOutExpo');
    	return false;
	});
	/* End Back to top scroll */
</script>
<script defer src="js/jquery.flexslider.js"></script>
<script type="text/javascript">
    $(window).load(function(){
	$('.mobile-nav').click(function(){
	// alert("kk");
	$("#main-navigation").slideToggle("slow");
	});
      $('.flexslider').flexslider({
        animation: "fade",
		slideshowSpeed: 3000
      });
	        $('.flexslider1').flexslider({
        animation: "fade",
		slideshowSpeed: 2200   
      });
	        $('.flexslider2').flexslider({
        animation: "fade",
		slideshowSpeed: 5000
      });
	        $('.flexslider3').flexslider({
        animation: "fade",
		slideshowSpeed: 2500   
      });
    });
  </script>
  
   <link rel="stylesheet" type="text/css" href="css/textslide.css" />
		<script type="text/javascript" src="js/modernizr.custom.28468.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Economica:700,400italic' rel='stylesheet' type='text/css'>
		<noscript>
			<link rel="stylesheet" type="text/css" href="css/nojs.css" />
		</noscript>
  
</head>
<body>
<a href="#" class="scrollup" title="Back to Top!">Scroll</a>
<div class="wrapper">
  <div class="top-navigtion" style="height:50px;">
    <div class="main">
      <ul class="nav-menu">
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="#">Blog</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
      <form name="form-search" method="post" action="search.php" class="form-search">
        <input type="text" name="search" placeholder="Search...." class="input-icon input-icon-search">
      </form>
      <ul class="social">
        <li><a href="#"><img alt="LinkedIn" src="images/linkedin-logo.png"></a></li>
        <li><a href="#"><img alt="Flickr" src="images/flickr.png"></a></li>
        <li><a href="#"><img alt="Facebook" src="images/facebook-logo.png"></a></li>
        <li><a href="#"><img alt="DeviantArt" src="images/deviantart.png"></a></li>
        <li><a href="#"><img alt="Twitter" src="images/twitter.png"></a></li>
        <li><a href="#"><img alt="Stumbleupon" src="images/stumbleupon.png"></a></li>
        <li><a href="#"><img alt="Skype" src="images/skype.png"></a></li>
      </ul>
      <div class="cl"></div>
    </div>
  </div>
  <header>
    <div class="main">
      <!-- Logo -->
      <div class="logo"> <a href="index.php"><img src="images/logo.png" alt="Maxwirenews" /></a> </div>
      <div class="mobile-nav"><a href="javascript:void(0);">Menu</a></div>
      <div class="top-right"> <?php if(isset($_SESSION['loginId'])){?><a href="myaccount.php" class="readmoreBtn" >My Account</a> <a href="logout.php" class="readmoreBtn">Logout</a>  <?php } else {?><a href="login.php" class="login">Login</a> <a href="register.php" class="create-account"><img src="images/create-account.png" alt="Create free Account" /></a><?php }?> <div class="cl"></div></div>
      <div class="cl"></div>
      <nav id="main-navigation">
        <ul>
          <li><a href="features.php">features</a></li>
          <li><a href="howitworks.php">how it works</a></li>
          <li><a href="pricing.php">pricing</a></li>
          <li><a href="mission.php">our mission</a></li>
          <li><a href="faq.php">faq</a></li>
          <li><a href="pressbulletin.php">news room</a></li>
        </ul>
        <div class="cl"></div>
      </nav>
    </div>
  </header>