						<div class="indent padding green">
							
							<div class="wrapper">
								
								<article class="col-1 col-pad">
									<h2>PRI Colima</h2>
									<img src="<?php print $this->themePath; ?>/images/page1-img1.jpg" alt="">
									<p>
										Lorem ipsum dolor sit amet, consec tetuer adipiscing elit. 
										Praesent vestibulum molestie lacus. Aenean nonummy hendrerit mauris. 
										Phasellus porta. Fusce suscipit varius mum sociis natoque penatibus et 
										magnis dis parturient montes, nascetur
									</p>
									<a href="#" class="link"><?php print __("Read more");?></a>
								</article>
								
								<article class="col-1 col-pad">
									<h2>Tecnolog&iacute;a</h2>
									<img src="<?php print $this->themePath; ?>/images/page1-img2.jpg" alt="">
									<p>
										Lorem ipsum dolor sit amet, consec tetuer adipiscing elit. 
										Praesent vestibulum molestie lacus. Aenean nonummy hendrerit mauris. 
										Phasellus porta. Fusce suscipit varius mum sociis natoque penatibus et 
										magnis dis parturient montes, nascetur
									</p>
									<a href="#" class="link"><?php print __("Read more");?></a>
								</article>
								
								<article class="col-1">
									<h2>Municipios</h2>
									<img src="<?php print $this->themePath; ?>/images/page1-img3.jpg" alt="">
									<p>
										Lorem ipsum dolor sit amet, consec tetuer adipiscing elit. 
										Praesent vestibulum molestie lacus. Aenean nonummy hendrerit mauris. 
										Phasellus porta. Fusce suscipit varius mum sociis natoque penatibus et 
										magnis dis parturient montes, nascetur
									</p>
									<a href="#" class="link"><?php print __("Read more");?></a>
								</article>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="block"></div>
		</section>
		
		<!-- footer -->
		<footer>
			<div class="main">
				<div class="inner">
					CiberPRI Colima © 2011 <a href="#"><?php print __("Privacy Policy");?></a>&nbsp; <!-- {%FOOTER_LINK} -->
				</div>			
			</div>
		</footer> 
		
		<?php 
		print getScript("nivo-slider");
		//$this->js("js/pretty-photo", "videos"); 
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
