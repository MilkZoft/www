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
		<?php if($amenities) { ?>
		<?php foreach($amenities as $amenity) { ?>
			<div class="room">
				
				<?php if($amenity["Image"] !== "") { ?>
					<img src="<?php print _webURL . _sh . $amenity["Image"];?>" title="<?php print $amenity["Name"];?>" alt="<?php print $amenity["Name"];?>" />
				<?php } ?>
				
				<p>
					<h2>
						<?php print $amenity["Name"];?>
					</h2>
				</p>
			</div>
		<?php  } ?>
	<?php } else { ?>
		<?php print __("This hotel has added amenities");?>
	<?php } ?>
</div>

<script type="text/javascript">
	var PATHAPP = "<?php print _webBase . _sh . _webLang . _sh . whichApplication() . _sh;?>";
</script>

