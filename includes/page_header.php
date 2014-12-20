<?php 
/* 	
 *	Include the entire page header into several pages with only one area
 *	(this file, page_header.php) as the source. 
 */
 
include('session.php');
startUserSession();
?>
 
<!DOCTYPE html>
<html>
<head>
    <title>DripDrop - Search for Public Toilets</title>
  	<meta content="initial-scale=1.0; maximum-scale=1.0; user-scalable=yes" name="viewport"/>
    <meta name="description" content=" DripDrop is your local public toilet searcher. Find a location to go before you start your trip." />
    <meta name="keywords" content=" DripDrop, Toilet, Search, Where, Find, Local, Public Toilet, Site ">
    <meta name="author" content="Jackson Powell">
    <meta charset="utf-8" />
    <!--[if IE]>
		<link rel="stylesheet" type="text/css" href="stylesheets/style.css" />
	<![endif]-->
	<script type="text/javascript" src="js/search.js"></script>
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
	<meta property="og:image" content="http://54.206.43.109/~n8600571/a2/images/homescreen_icon.png" />
	<meta property="og:title" content="DripDrop - Search for Brisbane toilets!" />
	<meta property="og:description" content="DripDrop is your local public toilet searcher. Find a location to go before you start your trip." />
    
    <!-- Designating the correct view. Mobile/PC based on screen size  -->
    <link rel="stylesheet" type="text/css" href="stylesheets/mobile.css" media="screen and (max-width: 480px)"/>
  	<link rel="stylesheet" type="text/css" href="stylesheets/style.css" media="only screen and (min-width: 480px)"/>
	
	<!-- Device native design meta data -->
    <meta name="viewport" content="width=device-width">
	<meta name="mobile-web-app-capable" content="yes">
	<link rel="apple-touch-icon" href="images/homescreen_icon.png"/>
</head>

<body>

	<!-- Begin header -->
	<div id="header">
    
        <div class="centre_container">
            <div id="logo_image"></div>
        </div>
        
        <!-- Main navigation below Logo area -->
        <div id="navigation_bg">
        	<div id="navigation_bar">
                <div class="centre_container">
                	<ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="search.php">Search Toilets</a></li>
                        <!-- Provided login form form every page header navigation -->
                        <li> <?php include ("user_login_form.php"); ?> </li>
                        <!-- If we're logged in, do not display register button. -->
                        <?php if(!checkLogin($pdo)) { ?><li><a href="register.php">Register</a></li><?php } ?>
                        <!-- If we're an admin, display admin control panel button. -->
						<?php if(isset($_SESSION['is_admin'])) {
							if($_SESSION['is_admin']) { ?>
                            <li><a href="admin_cp.php">Admin CP</a></li>
							<?php }
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
        
    </div>
    
	<?php 
	//Allow alerts for simply tasks, on every page, success="AlertName" etc.
    if (!empty($_GET["success"])) { 
        echo "<div class=\"alert_success\"><h4>".$_GET["success"]."</h4></div>"; 
    }
	if (!empty($_GET["failure"])) { 
        echo "<div class=\"alert_fail\"><h4>".$_GET["failure"]."</h4></div>"; 
    }
    ?>