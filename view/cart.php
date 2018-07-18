<?php 
$pagename = $data['pagename'];
if(isset($data['cart_items'])) {
  $cart_items = $data['cart_items'];
}


$success = "";
if(isset($_SESSION['success'])) 
{
    $success = $_SESSION['success'];
}
$_SESSION['success'] = '';
unset($_SESSION['success']);
$error = "";
if(isset($_SESSION['error'])) 
{
    $error = $_SESSION['error'];
}
$_SESSION['error'] = '';
unset($_SESSION['error']);

?>
<!doctype html>
<html>
  <?php include "head.php";?>

  <body>
    <?php include "header.php";?>
    <div class="container mb-8">
      <div class="py-5 text-center">
        <h2>Your cart</h2>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <?php if(isset($cart_items) && !empty($cart_items)) 
          {?>
          <ul class="list-group mb-3">
            <?php 
            $totalprice = 0;

            foreach ($cart_items as $productid => $cart_item) 
            {
              $productname = $data['productname'][$productid];
              echo '<li class="list-group-item ">
                      <form class="row no-gutters" action="" method="POST">
                        <div class="col-4 col-sm-4 col-md-3">
                          <input name="productid" type="hidden" value="'.$productid.'">
                          <h6 class="my-0">'.$productname.' <span class="badge badge-secondary badge-pill">'.$cart_item['productqty'].'</span></h6>
                        </div>
                        <div class="col-4 col-sm-4 col-md-2">
                          <span class="text-muted">$'.$cart_item['productprice'].' </span>
                        </div>
                        <div class="col-4 col-sm-4 col-md-3">
                        </div>
                        <div class="d-block d-sm-block d-md-none mb-1">&nbsp;</div>
                        <div class="col-12 col-sm-12 col-md-4">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Qty:</span>
                            </div>
                            <input name="productqty" type="number" class="form-control" min="1" value="'.$cart_item['productqty'].'">
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="submit" name="update">Update</button>
                            </div>
                            <div class="input-group-append"> 
                              <button class="btn btn-danger" type="submit" name="delete">&times;</button> 
                            </div>
                          </div>
                          
                        </div>
                      </form>
                    </li>';
              $totalprice += $cart_item['productprice'];
            }?>
            <li class="list-group-item d-flex justify-content-between">
              <span>Total (USD)</span>
              <strong>$<?php echo $totalprice;?></strong>
            </li>
          </ul>
          <div class="row">
            <div class="col-12">
              <a href="checkout" class="btn btn-secondary float-right mb-2">Checkout</a>
            </div>
          </div>
          <?php } else { ?>
            <div class="col-12">
              <?php if(isset($success) && $success != '') 
              { ?>
                <h4 class="mb-3 text-center"><?php echo $success; ?></h4>
              <?php } else {?>
              <h4 class="mb-3 text-center">Your Cart is empty, Please add products in your cart.</h4>
              <?php } ?>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="clearfix"><br></div>
    <?php include "foot.php";?>
    
  </body>
</html>