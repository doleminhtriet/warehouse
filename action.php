	<?php
	session_start();
	$ip_add = getenv("REMOTE_ADDR");
	include "db.php";


	if (isset($_POST["category"])) {
		$category_query = "SELECT * FROM Category";

		$run_query = mysqli_query($con, $category_query) or die(mysqli_error($con));
		echo "
			
				
				<div class='aside'>
								<h3 class='aside-title'>Categories</h3>
								<div class='btn-group-vertical'>
		";
		if (mysqli_num_rows($run_query) > 0) {
			$i = 1;
			while ($row = mysqli_fetch_array($run_query)) {

				$cid = $row["CatID"];
				$cat_name = $row["CategoryName"];
				$sql = "SELECT COUNT(*) AS count_items FROM Product WHERE CatID=$i";
				$query = mysqli_query($con, $sql);
				$row = mysqli_fetch_array($query);
				$count = $row["count_items"];
				$i++;


				echo "
						
						<div type='button' class='btn navbar-btn category' cid='$cid'>
										
										<a href='#'>
											<span  ></span>
											$cat_name
											<small class='qty'>($count)</small>
										</a>
									</div>
						
				";
			}


			echo "</div>";
		}
	}

	if (isset($_POST["page"])) {
		$sql = "SELECT * FROM Product";
		$run_query = mysqli_query($con, $sql);
		$count = mysqli_num_rows($run_query);
		$pageno = ceil($count / 9);
		for ($i = 1; $i <= $pageno; $i++) {
			echo "
				<li><a href='#product-row' page='$i' id='page' class='active'>$i</a></li>
				
				
			";
		}
	}
	if (isset($_POST["getProduct"])) {
		$limit = 9;
		if (isset($_POST["setPage"])) {
			$pageno = $_POST["pageNumber"];
			$start = ($pageno * $limit) - $limit;
		} else {
			$start = 0;
		}
		$product_query = "SELECT * FROM Product,Category WHERE Product.CatID=Category.CatID LIMIT $start,$limit";
		$run_query = mysqli_query($con, $product_query);
		if (mysqli_num_rows($run_query) > 0) {
			while ($row = mysqli_fetch_array($run_query)) {
				$pro_id    = $row['ProductID'];
				$pro_title = $row['ProductName'];
				$pro_price = $row['ProductPrice'];
				$pro_image = $row['ProductImage'];
				$stockQty = $row['ProductQTY'];
				$cat_name = $row["CategoryName"];
				echo "
					
							
							<div class='col-md-4 col-xs-6' >
									<a href='product.php?p=$pro_id'><div class='product'>
										<div class='product-img'>
										<img src='data:image/jpeg;base64," . $pro_image . "' style='max-height: 170px;' alt=''>
											
										</div></a>
										<div class='product-body'>
											<p class='product-category'>$cat_name</p>
											<h3 class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
											<h4 class='product-price header-cart-item-info'>$pro_price</h4>
											
											
										</div>
										<div class='add-to-cart'>
											<button pid='$pro_id' id='product' class='add-to-cart-btn block2-btn-towishlist' href='#'><i class='fa fa-shopping-cart'></i> add to cart</button>
										</div>
									</div>
								</div>
							
				";
			}
		}
	}


	if (isset($_POST["get_seleted_Category"])  ) {
		if (isset($_POST["get_seleted_Category"])) {
			$id = $_POST["cat_id"];
			$sql = "SELECT * FROM Product, Category WHERE Product.CatID = '$id' AND Product.CatID=Category.CatID";
		}

		$run_query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_array($run_query)) {
			$pro_id    = $row['ProductID'];
			$pro_cat   = $row['CatID'];
			$pro_title = $row['ProductName'];
			$pro_price = $row['ProductPrice'];
			$pro_image = $row['ProductImage'];
			$cat_name = $row["CategoryName"];
			$stockQty = $row['ProductQTY'];
			echo "
						
							
							<div class='col-md-4 col-xs-6'>
									<a href='product.php?p=$pro_id'><div class='product'>
										<div class='product-img'>
											<img src='data:image/jpeg;base64,$pro_image' style='max-height: 170px;' alt=''>

										</div></a>
										<div class='product-body'>
											<p class='product-category'>$cat_name</p>
											<h3 class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
											<h4 class='product-price header-cart-item-info'>$pro_price</h4>
											
										</div>
										<div class='add-to-cart'>
											<button pid='$pro_id' id='product' href='#' tabindex='0' class='add-to-cart-btn'><i class='fa fa-shopping-cart'></i> add to cart</button>
										</div>
									</div>
								</div>
				";
		}
	}



	if (isset($_POST["addToCart"])) {

		$p_id = $_POST["proId"];
		echo "addToCart";

		if (isset($_SESSION["uid"])) {

			$user_id = $_SESSION["uid"];

			$sql = "SELECT * FROM Cart WHERE ProductID = '$p_id' AND UserID = '$user_id'";
			$run_query = mysqli_query($con, $sql);
			$count = mysqli_num_rows($run_query);

			if ($count > 0) {

				echo "
					<div class='alert alert-warning'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<b>Product is already added into the cart Continue Shopping..!</b>
					</div>
				"; //not in video
			} else {
				$sql = "INSERT INTO `Cart`
				(`ProductID`, `IpAdd`, `UserID`, `CartQTY`) 
				VALUES ('$p_id','$ip_add','$user_id','1')";
				if (mysqli_query($con, $sql)) {
					echo "
						<div class='alert alert-success'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<b>Product is Added..!</b>
						</div>
					";
				}
			}
		} else {
			$sql = "SELECT CartID FROM Cart WHERE IpAdd = '$ip_add' AND ProductID = '$p_id' AND UserID = -1";
			$query = mysqli_query($con, $sql);
			if (mysqli_num_rows($query) > 0) {
				echo "
						<div class='alert alert-warning'>
								<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
								<b>Product is already added into the cart Continue Shopping..!</b>
						</div>";
				exit();
			}
			$sql = "INSERT INTO `Cart`
				(`ProductID`, `IpAdd`, `UserID`, `CartQTY`) 
				VALUES ('$p_id','$ip_add','-1','1')";
			if (mysqli_query($con, $sql)) {
				echo "
						<div class='alert alert-success'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<b>Your product is Added Successfully..!</b>
						</div>
					";
				exit();
			}
		}
	}

	//Count User cart item
	if (isset($_POST["count_item"])) {
		//When user is logged in then we will count number of item in cart by using user session id
		if (isset($_SESSION["uid"])) {
			$sql = "SELECT COUNT(*) AS count_item FROM Cart WHERE UserID = $_SESSION[uid]";
		} else {
			//When user is not logged in then we will count number of item in cart by using users unique ip address
			$sql = "SELECT COUNT(*) AS count_item FROM Cart WHERE IpAdd = '$ip_add' AND UserID < 0";
		}

		$query = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($query);
		echo $row["count_item"];
		exit();
	}
	//Count User cart item

	//Get Cart Item From Database to Dropdown menu
	if (isset($_POST["Common"])) {

		if (isset($_SESSION["uid"])) {
			//When user is logged in this query will execute
			$sql = "SELECT a.ProductID,a.ProductName,a.ProductPrice, a.ProductDescription,a.ProductImage,b.CartID, b.CartQTY, a.ProductQTY FROM Product a, Cart b WHERE a.ProductID=b.ProductID AND b.UserID='$_SESSION[uid]'";
		} else {
			//When user is not logged in this query will execute
			$sql = "SELECT a.ProductID,a.ProductName, a.ProductDescription, a.ProductPrice,a.ProductImage,b.CartID, b.CartQTY, a.ProductQTY FROM Product a, Cart b WHERE a.ProductID=b.ProductID AND b.IpAdd='$ip_add' AND b.UserID < 0";
		}
		$query = mysqli_query($con, $sql);
		if (isset($_POST["getCartItem"])) {
			//display cart item in dropdown menu
			if (mysqli_num_rows($query) > 0) {
				$n = 0;
				$total_price = 0;
				while ($row = mysqli_fetch_array($query)) {

					$n++;
					$product_id = $row["ProductID"];
					$product_title = $row["ProductName"];
					$product_price = $row["ProductPrice"];
					$product_image = $row["ProductImage"];
					$cart_item_id = $row["CartID"];
					$qty = $row["CartQTY"];
					$stockQty = $row["ProductQTY"];
					$total_price = $total_price + $product_price;

					echo '
						
						
						<div class="product-widget">
													<div class="product-img">
													<img src="data:image/jpeg;base64,' . $product_image . '" alt="">
													</div>
													<div class="product-body">
														<h3 class="product-name"><a href="#">' . $product_title . '</a></h3>
														<h4 class="product-price"><span class="qty">' . $n . '</span>$' . $product_price . '</h4>
													</div>
													
												</div>';
				}

				echo '<div class="cart-summary">
						<small class="qty">' . $n . ' Item(s) selected</small>
						<h5>$' . $total_price . '</h5>
					</div>'
	?>
					
					
				<?php

				exit();
			}
		}



		if (isset($_POST["checkOutDetails"])) {
			if (mysqli_num_rows($query) > 0) {

				//display user cart item with "Ready to checkout" button if user is not login
				echo '<div class="main ">
				<div class="table-responsive">
				<form method="post" action="login_form.php">
				
					<table id="cart" class="table table-hover table-condensed" id="">
						<thead>
							<tr>
								<th style="width:50%">Product</th>
								<th style="width:10%">Price</th>
								<th style="width:8%">Quantity</th>
								<th style="width:7%" class="text-center">Subtotal</th>
								<th style="width:10%"></th>
							</tr>
						</thead>
						<tbody>
						';
				$n = 0;

				while ($row = mysqli_fetch_array($query)) {

					$n++;
					$product_id = $row["ProductID"];
					$product_title = $row["ProductName"];
					$product_desc = $row["ProductDescription"];
					$product_price = $row["ProductPrice"];
					$product_image = $row["ProductImage"];
					$cart_item_id = $row["CartID"];
					$qty = $row["CartQTY"];
					$stockQty = $row["ProductQTY"];

					echo
					'
								
							<tr>
								<td data-th="Product" rowspan ="2">
									<div class="row">
									C
										<div class="col-sm-4 "><img src="data:image/jpeg;base64,' . $product_image . '" style="height: 70px;width:75px;"/>
										<h4 class="nomargin product-name header-cart-item-name"><a href="product.php?p=' . $product_id . '">' . $product_title . '</a></h4>
										</div>
										<div class="col-sm-6">
											<div style="max-width=50px;">
											<p>' . $product_desc . '</p>
											</div>
										</div>
										
										
									</div>
								</td>
								<input type="hidden" name="product_id[]" value="' . $product_id . '"/>
								<input type="hidden" name="" value="' . $cart_item_id . '"/>
								<td data-th="Price"><input type="text" class="form-control price" value="' . $product_price . '" readonly="readonly"></td>
								<td data-th="Quantity">
									<input type="text" class="form-control qty" value="' . $qty . '" >
								</td>
								<td data-th="Subtotal" class="text-center"><input type="text" class="form-control total" value="' . $product_price . '" readonly="readonly"></td>
								<td class="actions" data-th="">
								<div class="btn-group">
									<a href="#" class="btn btn-info btn-sm update" update_id="' . $product_id . '"><i class="fa fa-refresh"></i></a>
									
									<a href="#" class="btn btn-danger btn-sm remove" remove_id="' . $product_id . '"><i class="fa fa-trash-o"></i></a>		
								</div>							
								</td>
							</tr>
							<tr>
							<td colspan="4" class="no-border"><span class="red-text">Quantity in stock: ' . $stockQty . '</span></td>
							</tr>
						
								
								';
				}

				echo '</tbody>
					<tfoot>
						
						<tr>
							<td><a href="store.php" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
							<td colspan="2" class="hidden-xs"></td>
							<td class="hidden-xs text-center"><b class="net_total" ></b></td>
							<div id="issessionset"></div>
							<td>
								
								';
				if (!isset($_SESSION["uid"])) {
					echo '
						
						<a href="" data-toggle="modal" data-target="#Modal_register" class="btn btn-success">NReady to Checkout</a></td>
								

									</tr>
								</tfoot>
					
								</table></div></div>';
				} else if (isset($_SESSION["uid"])) {
					//Paypal checkout form
					echo '
						</form>
						
							<form action="checkout.php" method="post">
								<input type="hidden" name="cmd" value="_cart">
								<input type="hidden" name="business" value="ledo@gmail.com">
								<input type="hidden" name="upload" value="1">';

					$x = 0;
					$sql = "SELECT a.ProductID,a.ProductName,a.ProductPrice,a.ProductImage, b.CartID, b.CartQTY FROM Product a,Cart b WHERE a.ProductID = b.ProductID AND b.UserId='$_SESSION[uid]'";
					$query = mysqli_query($con, $sql);
					while ($row = mysqli_fetch_array($query)) {
						$x++;
						echo $x;
						echo

						'<input type="hidden" name="total_count" value="' . $x . '">
										<input type="hidden" name="item_name_' . $x . '" value="' . $row["ProductName"] . '">
										<input type="hidden" name="item_number_' . $x . '" value="' . $x . '">
										<input type="hidden" name="amount_' . $x . '" value="' . $row["ProductPrice"] . '">
										<input type="hidden" name="quantity_' . $x . '" value="' . $row["CartQTY"] . '">';
					}

					echo
					'<input type="hidden" name="return" value="http://localhost/myfiles/public_html/payment_success.php"/>
										<input type="hidden" name="notify_url" value="http://localhost/myfiles/public_html/payment_success.php">
										<input type="hidden" name="cancel_return" value="http://localhost/myfiles/public_html/cancel.php"/>
										<input type="hidden" name="currency_code" value="USD"/>
										<input type="hidden" name="custom" value="' . $_SESSION["uid"] . '"/>
										<input type="submit" id="submit" name="login_user_with_product" name="submit" class="btn btn-success" value="xReady to Checkout">
										</form></td>
										
										</tr>
										
										</tfoot>
										
								</table></div></div>    
									';
				}
			}
		}
	}

	//Remove Item From cart
	if (isset($_POST["removeItemFromCart"])) {
		$remove_id = $_POST["rid"];
		if (isset($_SESSION["uid"])) {
			$sql = "DELETE FROM cart WHERE p_id = '$remove_id' AND user_id = '$_SESSION[uid]'";
		} else {
			$sql = "DELETE FROM cart WHERE p_id = '$remove_id' AND ip_add = '$ip_add'";
		}
		if (mysqli_query($con, $sql)) {
			echo "<div class='alert alert-danger'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<b>Product is removed from cart</b>
					</div>";
			exit();
		}
	}


	//Update Item From cart
	if (isset($_POST["updateCartItem"])) {
		$update_id = $_POST["update_id"];
		$qty = $_POST["qty"];
		if (isset($_SESSION["uid"])) {
			$sql = "UPDATE cart SET qty='$qty' WHERE p_id = '$update_id' AND user_id = '$_SESSION[uid]'";
		} else {
			$sql = "UPDATE cart SET qty='$qty' WHERE p_id = '$update_id' AND ip_add = '$ip_add'";
		}
		if (mysqli_query($con, $sql)) {
			echo "<div class='alert alert-info'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<b>Product is updated</b>
					</div>";
			exit();
		}
	}









				?>






