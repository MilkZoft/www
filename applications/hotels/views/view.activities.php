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
			<strong><?php print __("City ctivities");?></strong>:<br />
			<?php print ($hotel["City_Activities"] != "") ? $hotel["City_Activities"] : __("No activities");?>
		</p>	
		
		<p>
			<strong><?php print __("Hotel activities");?></strong>:<br />
			<?php print ($hotel["Hotel_Activities"] != "") ? $hotel["Hotel_Activities"] : __("No activities");?>
		</p>
			
		<p>
			<strong><?php print __("Hotel near activities");?></strong>:<br />
			<?php print ($hotel["Hotel_Near_Activities"] != "") ? $hotel["Hotel_Near_Activities"] : __("No activities");?>
		</p>
	</div>
</div>

<script type="text/javascript">
	var PATHAPP = "<?php print _webBase . _sh . _webLang . _sh . whichApplication() . _sh;?>";
</script>
