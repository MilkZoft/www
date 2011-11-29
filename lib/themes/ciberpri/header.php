<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?php print utf8_decode($this->getTitle());?></title>
		
		
		<link rel="stylesheet" href="<?php print $this->themePath; ?>/css/960gs/code/css/reset.css" />
		<link rel="stylesheet" href="<?php print $this->themePath; ?>/css/styles.css" />
		
		<?php #$this->CSS("polls", "polls"); ?>
		<?php //print $this->getCSS(); ?>
		<?php print $this->js("www/lib/scripts/js/jquery.js", NULL, NULL, TRUE);?>
		
	</head>
	<body id="page1">
		
		<!-- header -->
		<header>
			<div class="main">
				<div class="extra">
					<div class="inner">
						<section class="wrapper">
							<div class="socials">
								<a href="#"><img src="<?php print $this->themePath; ?>/images/email.gif" alt=""></a>
								<a href="#"><img src="<?php print $this->themePath; ?>/images/rss.gif" alt=""></a>
								<a href="#"><img src="<?php print $this->themePath; ?>/images/twitter.gif" alt=""></a>
								<a href="#"><img src="<?php print $this->themePath; ?>/images/facebook.gif" alt=""></a>
							</div>
						</section>
						<div class="wrapper">
							
							<section class="wrapper-logo">
								<img src="<?php print $this->themePath; ?>/images/logo_full_text.png" title="CIBERPRI" alt="ciberpri" /><br />
							</section>
							<div class="header-col">
								<nav>
									<ul>
										<li class="active"><a href="#"><?php print __("Start");?></a></li>
										<li><a href="#"><?php print __("Who are we?");?></a></li>
										<li><a href="#"><?php print __("Directory");?></a></li>
										<li><a href="#"><?php print __("Affiliates");?></a></li>
										<li><a href="#"><?php print __("Feedback");?></a></li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
	
		<!-- content -->
		<section id="content">
			
			<div class="main">
				
				<div class="extra">
					
					<div class="inner">
