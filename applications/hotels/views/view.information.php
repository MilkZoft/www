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
			<strong><?php print __("Description");?></strong>: 
			<?php print $hotel["Description"];?>
		</p>	
		
		<p>
			<strong><?php print __("Room numbers");?></strong>: 
			<?php print $hotel["Room_Number"];?>
		</p>
			
		<p>
			<strong><?php print __("Year Construction");?></strong>: 
			<?php print $hotel["Year_Construction"];?>
		</p>
		
		<p>
			<strong><?php print __("Year Remodelation");?></strong>: 
			<?php print $hotel["Year_Remodelation"];?>
		</p>
		
		<p>
			<strong><?php print __("In Time");?></strong><br />
			<?php print $hotel["In_Time"];?>
		</p>
		
		<p>
			<strong><?php print __("Out Time");?></strong><br />
			<?php print $hotel["Out_Time"];?>
		</p>
		
		<p>
			<strong><?php print __("Max Year Children");?></strong><br />
			<?php print $hotel["Max_Year_Children"];?>
		</p>
		
		<p>
			<strong><?php print __("Min Days Reservation");?></strong><br />
			<?php print $hotel["Min_Days_Reservation"];?>
		</p>
	</div>
</div>

<script type="text/javascript">
	var PATHAPP = "<?php print _webBase . _sh . _webLang . _sh . whichApplication() . _sh;?>";
</script>
