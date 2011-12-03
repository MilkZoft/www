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
								<a href="http://twitter.com/#!/CiberPRIColima"><img src="<?php print $this->themePath; ?>/images/twitter.gif" alt=""></a>
								<a href="http://www.facebook.com/profile.php?id=100003166167328"><img src="<?php print $this->themePath; ?>/images/facebook.gif" alt=""></a>
							</div>
						</section>
						<div class="wrapper">
							
							<section class="wrapper-logo">
								<img src="<?php print $this->themePath; ?>/images/logo_full_text.png" title="CIBERPRI" alt="ciberpri" /><br />
							</section>
							<div class="header-col">
								<nav>
									<ul>
										<li <?php print (segment(2) === slug(__("Home")) or segment(1) === slug(__("Home")) or (!segment(2) and !segment(1))) ? 'class="active"' : '' ;?>>
											<a href="<?php print _webBase . _sh . _webLang . _sh . "pages" . _sh . slug(__("Home"));?>"><?php print __("Programas del mn");?></a>
										</li>
										<li <?php print (segment(2) === slug(__("Who are we?")) or segment(1) === slug(__("Who are we?"))) ? 'class="active"' : '' ;?>>
											<a href="<?php print _webBase . _sh . _webLang . _sh . "pages" . _sh . slug(__("Who are we?"));?>"><?php print __("Who are we?");?></a>
										</li>
										<li <?php print (segment(2) === slug(__("Directory")) or segment(1) === slug(__("Directory"))) ? 'class="active"' : '' ;?>>
											<a href="<?php print _webBase . _sh . _webLang . _sh . "pages" . _sh . slug(__("Directory"));?>"><?php print __("Directory");?></a>
										</li>
										<li <?php print (segment(1) === "afiliate") ? 'class="active"' : '' ;?>>
											<a href="<?php print _webBase . _sh . _webLang . _sh . "afiliate";?>"><?php print __("Affiliates");?></a>
										</li>
										<li <?php print (segment(1) === "feedback") ? 'class="active"' : '' ;?>>
											<a href="<?php print _webBase . _sh . _webLang . _sh . "feedback";?>"><?php print __("Feedback");?></a>
										</li>
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
