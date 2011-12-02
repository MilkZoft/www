<?php if(!defined("_access")) die("Error: You don't have permission to access here..."); ?>

<div id="feedback" class="grid_9">	
	<form method="post" class="" action="#top" enctype="multipart/form-data">
		<fieldset>
			<legend><?php print __("Feedback"); ?></legend>
			<a name="top"></a>	
			<?php print isset($alert) ? $alert : NULL; ?>
						

			<p class="justify" id="info">
				Tel: +52 (312) 323 4064 <br />
				Cel: (312) 132  8113, (312)  109 3633 <br />
				ciberpricolima@gmail.com <br />
				<img src="" alt="Facebook" title="Facebook"/> <strong>Cibernautas PRI</strong>
			</p>
			
			<div class="forms_feedback">
				<p class="field">&raquo; <?php print __("Name"); ?><br />
					<input name="name" type="text" class="required" value="<?php print recoverPOST("name"); ?>" tabindex="1" />
				</p>
				
				<p class="field">&raquo; <?php print __("E-Mail"); ?><br />
					<input name="email" type="text" class="required" value="<?php print recoverPOST("email"); ?>" tabindex="2" />
				</p>
													
			
				<p class="field">&raquo; <?php print __("Message"); ?><br />
					<textarea id="editor" name="message" class="required" tabindex="6">
						<?php print recoverPOST("message"); ?>
					</textarea>
				</p>
				
				<p>
					<input name="send" type="submit" value="<?php print __("Send");?>" tabindex="7" class="send" />
				</p>  
			</div>			
			         
		</fieldset>
	</form>
</div>
