			<!-- Footer -->
			<div id="footer" class="container_12">
				<div class="footer-box f1 grid_3">		
					<p class="padding_5 center"><a href="<?php print _webBase . _sh . _webLang . _sh . "pages" . _sh . slug(__("Services"));?>"><?php print __("Services");?></a></p>
				</div>
				
				<div class="footer-box f2 grid_3">	
					<p class="padding_5 center"><a href="<?php print _webBase . _sh . _webLang . _sh . "pages" . _sh . slug(__("Special combos"));?>"><?php print __("Special combos");?></a></p>
				</div>
				
				<div class="footer-box f3 grid_3">	
					<p class="padding_5 center"><a href="<?php print _webBase . _sh . _webLang . _sh . "pages" . _sh . slug(__("Souvenirs"));?>"><?php print __("Souvenirs");?></a></p>
				</div>
				
				<div class="footer-box f4 grid_3">	
					<p class="padding_5 center"><a href="<?php print _webBase . _sh . _webLang . _sh . "pages" . _sh . slug(__("Alimentation"));?>"><?php print __("Alimentation");?></a></p>
				</div>	
			</div>
			
			<!-- Credits -->
			<div id="credits" class="container_12">
				<p class="center">
					<span class="uppercased">Créditos</span> <br />
					Fotografía: Fernando Chávez, Sandra Ezquivel <br />
					Diseño Web: Sandra Ezquivel (sandra.ezquivel@gmail.com) <br />
					Desarrollo WEB: <a href="http://www.milkzoft.com">MilkZoft</a>
				</p>
			</div>
			
		</div>
				
		<?php 
		print getScript("nivo-slider");
		$this->js("js/pretty-photo", "videos"); 
		$this->js("js/jquery.prettyPhoto", "videos");
		print $this->getJs();
		?> 
		<script type="text/javascript">
			$(document).ready( function () {
				$("a[rel^='prettyPhoto']").prettyPhoto();
			});
		</script>
	</body>

</html>
