<?php
include "header.php";
?>
<!-- /BREADCRUMB -->
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event) {
			event.preventDefault();
			$('html,body').animate({
				scrollTop: $(this.hash).offset().top
			}, 900);
		});
	});
</script>
<script>
	(function(global) {
		if (typeof(global) === "undefined") {
			throw new Error("window is undefined");
		}
		var _hash = "!";
		var noBackPlease = function() {
			global.location.href += "#";
			// making sure we have the fruit available for juice....
			// 50 milliseconds for just once do not cost much (^__^)
			global.setTimeout(function() {
				global.location.href += "!";
			}, 50);
		};
		// Earlier we had setInerval here....
		global.onhashchange = function() {
			if (global.location.hash !== _hash) {
				global.location.hash = _hash;
			}
		};
		global.onload = function() {
			noBackPlease();
			// disables backspace on page except on input fields and textarea..
			document.body.onkeydown = function(e) {
				var elm = e.target.nodeName.toLowerCase();
				if (e.which === 8 && (elm !== 'input' && elm !== 'textarea')) {
					e.preventDefault();
				}
				// stopping event bubbling up the DOM tree..
				e.stopPropagation();
			};
		};
	})(window);
</script>

<!-- SECTION -->
<div class="section main main-raised">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<!-- Product main img -->

			<?php
			include 'db.php';
			$product_id = $_GET['p'];

			$sql = " SELECT * FROM Product ";
			$sql = " SELECT * FROM Product WHERE ProductID = $product_id";
			if (!$con) {
				die("Connection failed: " . mysqli_connect_error());
			}
			$result = mysqli_query($con, $sql);
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					echo '
									
                                    
                                
                                <div class="col-md-5 col-md-push-2">
                                <div id="product-main-img">
                                    <div class="product-preview">
                                        <img src="data:image/jpeg;base64,' . $row['ProductImage'] . '" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="data:image/jpeg;base64,' . $row['ProductImage'] . '" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="data:image/jpeg;base64,' . $row['ProductImage'] . '" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="data:image/jpeg;base64,' . $row['ProductImage'] . '" alt="">
                                    </div>
                                </div>
                            </div>
                                
                                <div class="col-md-2  col-md-pull-5">
                                <div id="product-imgs">
                                    <div class="product-preview">
                                        <img src="data:image/jpeg;base64,' . $row['ProductImage'] . '" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="data:image/jpeg;base64,' . $row['ProductImage'] . '" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="data:image/jpeg;base64,' . $row['ProductImage'] . 'g" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="data:image/jpeg;base64,' . $row['ProductImage'] . '" alt="">
                                    </div>
                                </div>
                            </div>

                                 
									';

			?>
					<!-- FlexSlider -->

			<?php
					echo '
									
                                    
                                   
                    <div class="col-md-5">
						<div class="product-details">
							<h2 class="product-name">' . $row['ProductName'] . '</h2>
							
							<div>
								<h3 class="product-price">$' . $row['ProductPrice'] . '</h3>
								<span class="product-available">In Stock</span>
							</div>
							<p>'.$row['ProductDescription'].'</p>

							

							<div class="add-to-cart">
								
								<div class="btn-group" style="margin-left: 25px; margin-top: 15px">
								<button class="add-to-cart-btn" pid="' . $row['ProductID'] . '"  id="product" ><i class="fa fa-shopping-cart"></i> add to cart</button>
                                </div>
								
								
							</div>

							
							

							
						</div>
					</div>
									
					
					<!-- /Product main img -->

					<!-- Product thumb imgs -->
					
					
					
					<!-- /Product thumb imgs -->

					<!-- Product details -->
					
					<!-- /Product details -->

					<!-- Product tab -->
					
					<!-- /product tab -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- Section -->
		<div class="section main main-raised">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
                    
				
                    ';
					$_SESSION['product_id'] = $row['ProductID'];
				}
			}
			?>
			
			<!-- product -->

			<!-- /product -->

		</div>
		<!-- /row -->

	</div>
	<!-- /container -->
</div>
<!-- /Section -->

<!-- NEWSLETTER -->

<!-- /NEWSLETTER -->

<!-- FOOTER -->
<?php

include "footer.php";

?>