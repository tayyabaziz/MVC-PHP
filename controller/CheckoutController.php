<?php
include __DIR__ . '/Controller.php';
class CheckoutController extends Controller
{
	private $controller;
	
	function __construct()
	{
		$controller = new parent();
		$pagename = "checkout";
		$data = array();
		$data['pagename'] = $pagename;
		if(isset($_SESSION['cart_items'])) {
			$data['cart_items'] = $_SESSION['cart_items'];
			$productsmodel = $controller->model('ProductsModel');
			$productdetailmodel = $controller->model('ProductDetailModel');
			foreach ($data['cart_items'] as $productid => $cart_item) 
			{
				$data['product'][$productid] = $productdetailmodel->GetProduct($productid);
				$data['productname'][$productid] = $productdetailmodel->GetProductName($productid);
			}
		}

		$checkoutmodel = $controller->model('CheckoutModel');

		if(isset($_POST['checkout'])) 
		{
		  $orderdata['firstname'] = $_POST['firstname'];
		  $orderdata['lastname'] = $_POST['lastname'];
		  $orderdata['phonenumber'] = $_POST['phonenumber'];
		  $orderdata['email'] = $_POST['email'];
		  $orderdata['address'] = $_POST['address'];
		  $orderdata['address2'] = $_POST['address2'];
		  $orderdata['shippingmethod'] = $_POST['shippingmethod'];
		  $orderdata['cart_items'] = $_SESSION['cart_items'];

		  $results = $checkoutmodel->AddOrder($orderdata, $_SESSION['userid']);
		  if($results) 
		  {
		    unset($_SESSION['cart_items']);
		    $_SESSION['success'] = "Your order has been placed.";
		    $_SESSION['orderid'] = $results;
		  }
		  else {
		    $_SESSION['error'] = "Error occured while placing an order.";
		  }
		  header('Location: checkout');
		  exit();
		}

		if(isset($_SESSION['orderid'])) {
			$data['orderamountdetails'] = $checkoutmodel->getOrderAmountDetails($_SESSION['orderid']);
		}

		$controller->view('checkout', $data);
	}
}