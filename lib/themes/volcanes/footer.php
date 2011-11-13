			<!-- Footer -->
			<div id="footer" class="container_12">
				<div class="footer-box f1 grid_3">		
					<p><a href="<?php print _webBase . _sh . _webLang . _sh . "pages" . _sh . slug(__("Services"));?>">Servicios</a></p>
				</div>
				
				<div class="footer-box f2 grid_3">	
					<p><a href="<?php print _webBase . _sh . _webLang . _sh . "pages" . _sh . slug(__("Special packages"));?>">Paquetes Especiales</a></p>
				</div>
				
				<div class="footer-box f3 grid_3">	
					<p><a href="<?php print _webBase . _sh . _webLang . _sh . "pages" . _sh . slug(__("Souvenirs"));?>">Souvenirs</a></p>
				</div>
				
				<div class="footer-box f4 grid_3">	
					<p><a href="<?php print _webBase . _sh . _webLang . _sh . "pages" . _sh . slug(__("Alimentation"));?>">Alimentación</a></p>
				</div>	
			</div>
			
			<!-- Credits -->
			<div id="credits" class="container_12">
				<p>
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
		print $this->getJs();
		?> 
		
	</body>

</html>
