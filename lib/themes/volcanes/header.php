<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?php print utf8_decode($this->getTitle());?></title>
		
		
		<link rel="stylesheet" href="<?php print $this->themePath; ?>/css/960gs/code/css/reset.css" />
		<link rel="stylesheet" href="<?php print $this->themePath; ?>/css/960gs/code/css/text.css" />
		<link rel="stylesheet" href="<?php print $this->themePath; ?>/css/960gs/code/css/960.css" />
		<link rel="stylesheet" href="<?php print $this->themePath; ?>/css/960gs/code/css/demo.css" />
		<link rel="stylesheet" href="<?php print $this->themePath; ?>/css/styles.css" />
		
		<?php #$this->CSS("polls", "polls"); ?>
		<?php print $this->getCSS(); ?>
		<?php print $this->js("www/lib/scripts/js/jquery.js", NULL, NULL, TRUE);?>
		
	</head>
	<body>
		
		<!-- Main Container -->
		<div id="main-container" class="container_12">
			
			
			<!-- Header -->
			<div id="header" class="container_12" >	
				<div class="language en"><a href="<?print _webURL._sh."en";?>"></a></div>
				<div class="language es"><a href="<?print _webURL._sh."es";?>"></a></div>
				
				<?php
				if(segment(2) === "hospedaje" OR segment(2) == "lodge") {
					print '<div id="logo-inside"></div>'; 
				}
				
				?>
				
				<div id="slider" class="nivoSlider">
					<img src="<?php print $this->themePath; ?>/images/slider/bg.png" />
					<img src="<?php print $this->themePath; ?>/images/slider/bg-2.png" />
					<img src="<?php print $this->themePath; ?>/images/slider/bg-3.png" />
					<img src="<?php print $this->themePath; ?>/images/slider/bg-4.png" />
					<img src="<?php print $this->themePath; ?>/images/slider/bg-5.png" />
					<img src="<?php print $this->themePath; ?>/images/slider/bg-6.png" />
					<img src="<?php print $this->themePath; ?>/images/slider/bg-7.png" />
				</div>
			</div>
			
			<!-- Menu -->
			<div id="menu" class="container_12">
				<ul class="container_12">
					<li class="grid_2"><a href="<?php print _webBase . _sh . _webLang . _sh . "pages" . _sh;?>"><?php print __("Resort");?></a></li>
					<li class="grid_2"><a href="<?php print _webBase . _sh . _webLang . _sh . "pages" . _sh . slug(__("Tours"));?>"><?php print __("Tours");?></a></li>
					<li class="grid_2"><a href="<?php print _webBase . _sh . _webLang . _sh . "pages" . _sh . slug(__("Lodge"));?>"><?php print __("Lodge");?></a></li>
					<li class="grid_2"><a href="<?php print _webBase . _sh . _webLang . _sh . "pages" . _sh . slug(__("Location"));?>"><?php print __("Location");?></a></li>
					<li class="grid_2"><a href="<?php print _webBase . _sh . _webLang . _sh . "pages" . _sh . slug(__("Courses"));?>"><?php print __("Courses");?></a></li>
					<li class="grid_2"><a href="<?php print _webBase . _sh . _webLang . _sh . "feedback";?>"><?php print __("Contact Us");?></a></li>
				</ul>
				
			</div>
