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
			<strong><?php print __("Restaurants");?></strong>:<br />
			<?php print ($hotel["Restaurants_Bar"] != "") ? $hotel["Restaurants_Bar"] : __("No restaurants");?>
		</p>
	</div>
</div>

<script type="text/javascript">
	var PATHAPP = "<?php print _webBase . _sh . _webLang . _sh . whichApplication() . _sh;?>";
</script>
