<!-- Navigation -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="./">Shopping Cart</a>
    <div class="navbar-nav d-md-none d-block">
      <a class="nav-link active" href="#" id="cart2">
        <i class="fa fa-shopping-cart"></i> Cart
        <span class="badge"><?php echo ((isset($_SESSION['cart_items']))?count($_SESSION['cart_items']):"0");?></span>
      </a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item <?if($pagename == "main") 
        { echo 'active';} ?>">
          <a class="nav-link" href="./">Home
            <?php if($pagename == "main") 
            { echo '<span class="sr-only">(current)</span>';} ?>
          </a>
        </li>
        <li class="nav-item <?if($pagename == "checkout") 
        { echo 'active';} ?>">
          <a class="nav-link" href="./checkout">Checkout
            <?php if($pagename == "checkout") 
            { echo '<span class="sr-only">(current)</span>';} ?>
          </a>
        </li>
        <li class="nav-item d-none d-md-block">
          <a class="nav-link active" href="#" id="cart">
            <i class="fa fa-shopping-cart"></i> Cart
            <span class="badge"><?php echo ((isset($_SESSION['cart_items']))?count($_SESSION['cart_items']):"0");?></span>
          </a>
        </li>
      </ul>
    </div>
    <div class="shopping-cart">
      <div class="shopping-cart-header">
        <i class="fa fa-shopping-cart cart-icon"></i><span class="badge"><?php echo ((isset($_SESSION['cart_items']))?count($_SESSION['cart_items']):"0");?></span>
        <div class="shopping-cart-total">
          <?php
          $totalamount = 0;
          if(isset($_SESSION['cart_items']) && !empty($_SESSION['cart_items'])) 
          {
            foreach ($_SESSION['cart_items'] as $productid => $cart_item) 
            {
              $totalamount += $cart_item['productprice'];
            }
          }
          ?>
          Total: <? echo $totalamount; ?>
        </div>
      </div> <!--end shopping-cart-header -->
      <ul class="shopping-cart-items">
        <?php
        if(isset($_SESSION['cart_items']) && !empty($_SESSION['cart_items'])) 
        {
          foreach ($_SESSION['cart_items'] as $productid => $cart_item) 
          {
            $product = $data['product'][$productid];
            echo '<li class="clearfix">
                    <img class="img-fluid" width="50px" src="images/'.$product->productimage.'" alt="item1" />
                    <h6 class="my-0">'.$product->productname.'</h6>
                    <h6 class="my-0">$'.$cart_item['productprice'].' </h6>
                    <h6 class="my-0">Quantity: '.$cart_item['productqty'].'</h6>
                  </li>';
          }
        }
        else {
          echo '<li class="clearfix">No item found in your cart.</li>';
        }
        ?>
      </ul>
      <a href="cart" class="btn btn-secondary float-left mb-2">View Cart</a>
      <a href="checkout" class="btn btn-secondary float-right mb-2">Checkout</a>
    </div> <!--end shopping-cart -->
  </div> <!--end container -->
</nav>
