<?php
session_start();
include "db.php";
include "./ultilities/function.php";
           


if (isset($_SESSION["uid"])) {

	$f_name = $_POST["firstname"];
	$address = $_POST['address'];
    $state = $_POST['state'];
    $zip= $_POST['zip'];
    $cardname= $_POST['cardname'];
    $cardnumber= $_POST['cardNumber'];
    $expdate= $_POST['expdate'];
    $cvv= $_POST['cvv'];
    $user_id=$_SESSION["uid"];
    $cardnumberstr=(string)$cardnumber;
    $total_count=$_POST['total_count'];
    $prod_total = $_POST['total_price'];
    
    
    $sql0="SELECT OrderId from `OrderInfo`";
    $runquery=mysqli_query($con,$sql0);
    if (mysqli_num_rows($runquery) == 0) {
        echo( mysqli_error($con));
        $order_id=1;
    }else if (mysqli_num_rows($runquery) > 0) {
        $sql2="SELECT MAX(OrderId) AS max_val from `OrderInfo`";
        $runquery1=mysqli_query($con,$sql2);
        $row = mysqli_fetch_array($runquery1);
        $order_id= $row["max_val"];
        $order_id=$order_id+1;
        echo( mysqli_error($con));
    }

	$sql = "INSERT INTO `OrderInfo` 
	(`OrderId`,`UserId`,`Address`, `City`, `State`, `Zip`, `Cardname`,`Cardnumber`,
    `Expdate`,`ProdCount`,`TotalAmt`,`Cvv`) 
	VALUES ($order_id, '$user_id',    '$address', '$city', '$state', '$zip','$cardname',
    '$cardnumberstr','$expdate','$total_count','$prod_total','$cvv')";


    if(mysqli_query($con,$sql)){
        $i=1;
        $prod_id_=0;
        $prod_price_=0;
        $prod_qty_=0;
        while($i<=$total_count){
            $str=(string)$i;
            $prod_id_+$str = $_POST['prod_id_'.$i];
            $prod_id=$prod_id_+$str;		
            $prod_price_+$str = $_POST['prod_price_'.$i];
            $prod_price=$prod_price_+$str;
            $prod_qty_+$str = $_POST['prod_qty_'.$i];
            $prod_qty=$prod_qty_+$str;
            $sub_total=(int)$prod_price*(int)$prod_qty;
            $stockQty = getProductByID($prod_id, $con);
            $sql1="INSERT INTO `OrderDetail` 
            (`OrderDetailID`,`OrderId`,`ProductID`,`OrderQTY`,`Amt`) 
            VALUES (NULL, '$order_id','$prod_id','$prod_qty','$sub_total')";
            if(mysqli_query($con,$sql1)){
                $del_sql="DELETE from Cart where UserID=$user_id";
                $update_sql="UPDATE Product SET ProductQTY=$stockQty-$prod_qty WHERE ProductID=$prod_id";
                if(mysqli_query($con,$del_sql) && mysqli_query($con,$update_sql)){
                    echo"<script>window.location.href='index.php'</script>";
                }else{
                    echo(mysqli_error($con));
                }

            }else{
                echo(mysqli_error($con));
            }
            $i++;


        }
    }else{

        echo(mysqli_error($con));
        
    }
    
}else{
    echo"<script>window.location.href='index.php'</script>";
}
	




?>