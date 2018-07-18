<?php 
$pagename = $data['pagename'];
$products = $data['products'];

$message = "";
if(isset($_SESSION['message'])) 
{
    $message = $_SESSION['message'];
}
$_SESSION['message'] = '';
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html>
<?php include "head.php";?>
<body>
    <?php include "header.php";?>
    <div class="container mb-8">
      <div class="row">
        <div class="col-lg-12">
          <?php if(isset($message) && $message != '') 
          { ?>
              <div class="alert alert-success small">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <span><?php echo $message; ?></span>
              </div>
          <?php } ?>
          <div class="row">
            <?foreach ($products as $key => $product) 
            {
              $ratingvalue = $data['ratingvalue'][$product->productid];
              $checkrating = $data['checkrating'][$product->productid];
              $ratingtext = "";
              if($checkrating) {
                $ratingtext = "readonly disabled";
              }
              else {
                $ratingtext = 'onchange="return this.form.submit();"';
              }
              echo '<div class="col-lg-4 col-md-6 mb-4">
                      <div class="card">
                        <img class="img-fluid card-img-top p-4" src="images/'.$product->productimage.'" alt="">
                        <div class="card-body">
                          <h4 class="card-title">
                            '.$product->productname.'
                            <span class="float-right">Rated: '.$ratingvalue.'</span>
                          </h4>
                          <p class="card-text justify-content">
                            <form action="" method="post">
                              Rate this Product
                              <input type="hidden" name="productid" value="'.$product->productid.'">
                              <input type="text" '.$ratingtext.' name="ratingvalue" value="'.$ratingvalue.'" class="rating" data-size="xs" >
                            </form>
                          </p>
                          <h5>$'.$product->productprice.'</h5>
                        </div>
                        <div class="card-footer">
                          <div class="row no-gutters">
                            <div class="col-12">
                              <form action="" method="post">
                                <div class="input-group input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">Qty:</span>
                                  </div>
                                  <input name="productqty" type="number" class="form-control" min="1" value="1">
                                  <div class="input-group-append">
                                    <button class="float-right btn btn-primary" name="addtocart" value="'.$product->productid.'" type="submit">
                                      Add
                                    </button>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>';
            }
            ?>
          </div>

        </div>
      </div>

    </div>

    <?php include "foot.php";?>
    <script type="text/javascript">
      $(".rating").rating({
        showClear: false,
        showCaption: false,
        step: 1
      });
    </script>
  </body>
</html>