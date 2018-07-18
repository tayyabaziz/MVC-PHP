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

if(isset($_SESSION['orderid'])) 
{
    $orderid = $_SESSION['orderid'];
}
$_SESSION['orderid'] = '';
unset($_SESSION['orderid']);

?>
<!doctype html>
<html>
  <?php include "head.php";?>

  <body>
    <?php include "header.php";?>
    <div class="container mb-8">
      <div class="py-5 text-center">
        <h2>Checkout</h2>
      </div>

      <div class="row">
        <?php if(isset($_SESSION['cart_items']) && !empty($_SESSION['cart_items'])) 
        {?>
        <div class="col-lg-4 order-lg-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your cart</span>
            <span class="badge badge-secondary badge-pill"><?php echo count($_SESSION['cart_items']);?></span>
          </h4>
          <ul class="list-group mb-3">
            <?php 
            $totalprice = 0;

            foreach ($_SESSION['cart_items'] as $productid => $cart_item) 
            {
              $productname = $data['productname'][$productid];
              echo '<li class="list-group-item d-flex justify-content-between lh-condensed">
                      <div>
                        <h6 class="my-0">'.$productname.' <span class="badge badge-secondary badge-pill">Qty: '.$cart_item['productqty'].'</span></h6>
                      </div>
                      <div>
                        <span class="text-muted">$'.$cart_item['productprice'].'</span>
                      </div>
                    </li>';
              $totalprice += $cart_item['productprice'];
            }?>
            <li class="list-group-item d-flex justify-content-between">
              <span>Total (USD)</span>
              <strong>$<?php echo $totalprice;?></strong>
            </li>
          </ul>
          <a href="cart" class="btn btn-secondary float-left mb-2">Edit Cart</a>
        </div>
        <div class="col-lg-8 order-lg-1">
          <?php if(isset($success) && $success != '') 
          { ?>
              <div class="alert alert-success small">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <span><?php echo $success; ?></span>
              </div>
          <?php } ?>
          <?php if(isset($error) && $error != '') 
          { ?>
              <div class="alert alert-danger small">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <span><?php echo $error; ?></span>
              </div>
          <?php } ?>
          <h4 class="mb-3">Billing address</h4>
          <form  action="" method="POST">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstname">First name</label>
                <input type="text" class="form-control" id="firstname"  name="firstname" placeholder="" value="" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastname">Last name</label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="" value="" required>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="phonenumber">Phone Number</label>
                <input type="tel" class="form-control" id="phonenumber" name="phonenumber" placeholder="03361234567" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="email">Email <span class="text-muted">(Optional)</span></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com">
              </div>
            </div>
            <div class="mb-3">
              <label for="address">Address</label>
              <input type="text" class="form-control" id="address" name="address" placeholder="Apartment number" required>
            </div>

            <div class="mb-3">
              <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
              <input type="text" class="form-control" id="address2" name="address2" placeholder="1234 Main St">
            </div>

            <h4 class="mb-3">Shipping Option</h4>

            <div class="d-block my-3">
              <div class="custom-control custom-radio">
                <input id="pickup" value="pickup" name="shippingmethod" type="radio" class="custom-control-input" required>
                <label class="custom-control-label" for="pickup">Pick up (USD $0)</label>
              </div>
              <div class="custom-control custom-radio">
                <input id="ups" value="ups" name="shippingmethod" type="radio" class="custom-control-input" required>
                <label class="custom-control-label" for="ups">UPS (USD $5)</label>
              </div>
            </div>
            
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg" type="submit" name="checkout">Checkout</button>
          </form>
        </div>
        <?php } else { ?>
          <div class="col-12">
            <?php if(isset($success) && $success != '') 
            { ?>
              <h4 class="mb-3 text-center"><?php echo $success; ?></h4>
              <?php 
              $getorderamountdetail = $data['orderamountdetails'];
              echo "<p class='text-center'>
                Previous Balance: $".round($getorderamountdetail->prevbalance, 2)."<br>
                Total Order Amount: $".round($getorderamountdetail->totalamount, 2)."<br>
                Remaining Balance: $".round($getorderamountdetail->newbalance, 2)."
              </p>";
              ?>
            <?php } else {?>
            <h4 class="mb-3 text-center">Your Cart is empty, Please select products to check out.</h4>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
    </div>
    <div class="clearfix"><br></div>
    <?php include "foot.php";?>
    
  </body>
</html>