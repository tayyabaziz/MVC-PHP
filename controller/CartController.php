<?php
include __DIR__ . '/Controller.php';
class CartController extends Controller
{
	private $controller;
	
	function __construct()
	{
		$controller = new parent();
		$pagename = "cart";
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

		if(isset($_REQUEST['delete'])) 
		{
		  $productid = $_REQUEST['productid'];
		  unset($_SESSION['cart_items'][$productid]);
		  header('Location: cart');
		  exit();
		}
		else if(isset($_REQUEST['update'])) 
		{
		  $productid = $_REQUEST['productid'];
		  $productqty = $_REQUEST['productqty'];
		  $price = $productdetailmodel->GetProductPrice($productid);

		  $_SESSION['cart_items'][$productid]['productqty'] = $productqty;
		  $itemprice = $_SESSION['cart_items'][$productid]['productqty']*$price;
		  $_SESSION['cart_items'][$productid]['productprice'] = $itemprice;
		  header('Location: cart');
		  exit();
		}
		
		$controller->view('cart', $data);
	}
}