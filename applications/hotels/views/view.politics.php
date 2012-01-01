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
	
	<div class="information">	
	
		<p>
			<strong><?php print __("Cancellation Policy");?></strong>: 
			<?php print $hotel["Cancellation_Policy"];?>
		</p>	
		
		<p>
			<strong><?php print __("No Arrival Policy");?></strong>: 
			<?php print $hotel["No_Arrival_Policy"];?>
		</p>
			
		<p>
			<strong><?php print __("Extra Person Policy");?></strong>: 
			<?php print $hotel["Extra_Person_Policy"];?>
		</p>
		
		<p>
			<strong><?php print __("Childrens Policy");?></strong>: 
			<?php print $hotel["Childrens_Policy"];?>
		</p>
		
		<p>
			<strong><?php print __("Pets Policy");?></strong><br />
			<?php print $hotel["Pets_Policy"];?>
		</p>
		
		<p>
			<strong><?php print __("Pre Policy");?></strong><br />
			<?php print $hotel["Pre_Policy"];?>
		</p>
		
	</div>
</div>

<script type="text/javascript">
	var PATHAPP = "<?php print _webBase . _sh . _webLang . _sh . whichApplication() . _sh;?>";
</script>
