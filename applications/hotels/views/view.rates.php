<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	
	$selected  = 'selected="selected"';
	print isset($alert) ? $alert : NULL;
?>

<?php $this->view("header", array("hotel" => $hotel), $application);?>

<?php $this->view("options", array("slug" => $slug), $application);?>

<div id="contentSlide">
	<?php if($rates) { ?>
		<?php foreach($rates as $rate) { ?>
			<div class="rate">
				<p>
					<img src="" title="Bed" alt="Bed" />
					<h2>
						<?php print $rate["Name"];?>
					</h2>
				</p>
				
				<p>
					<strong><?php print __("Start date");?></strong>: 
					<?php print $rate["Start_Date_Text"];?>
				</p>
					
				<p>
					<strong><?php print __("End date");?></strong>: 
					<?php print $rate["End_Date_Text"];?>
				</p>
				
				<p>
					<strong><?php print __("Cost");?></strong>: 
					<?php print $rate["Cost"];?>
				</p>
			</div>
		<?php  } ?>
	<?php } else { ?>
		<?php print __("This hotel has added rates");?>
	<?php } ?>
</div>

<script type="text/javascript">
	var PATHAPP = "<?php print _webBase . _sh . _webLang . _sh . whichApplication() . _sh;?>";
</script>

