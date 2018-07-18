<?php
include __DIR__ . '/Controller.php';
class HomeController extends Controller
{
	private $controller;
	
	function __construct()
	{
		$controller = new parent();
		$pagename = "main";
		$data = array();
		$data['pagename'] = $pagename;
		$ipaddress = $controller->GetSystemIPAddress();
		$productsmodel = $controller->model('ProductsModel');
		$productdetailmodel = $controller->model('ProductDetailModel');
		$ratingsmodel = $controller->model('RatingsModel');

		$data['products'] = $productsmodel->GetAllProducts();
		
		foreach ($data['products'] as $key => $product) 
		{
			$data['product'][$product->productid] = $productdetailmodel->GetProduct($product->productid);
			$data['ratingvalue'][$product->productid] = round($ratingsmodel->GetRating($product->productid), 2);
          	$data['checkrating'][$product->productid] = $ratingsmodel->CheckRating($product->productid, $ipaddress);
		}
		
		if(isset($_POST['addtocart'])) 
		{
		  $productid = $_POST['addtocart'];
		  $productqty = isset($_POST['productqty']) ? $_POST['productqty'] : "";
		  
		  $price = $productdetailmodel->GetProductPrice($productid);
		  if(isset($_SESSION['cart_items'][$productid]['productqty'])) 
		  {
		    $productqty += $_SESSION['cart_items'][$productid]['productqty'];
		  }
		  $_SESSION['cart_items'][$productid]['productqty'] = $productqty;
		  $itemprice = $_SESSION['cart_items'][$productid]['productqty']*$price;
		  $_SESSION['cart_items'][$productid]['productprice'] = $itemprice;

		  $_SESSION['message'] = "Item added to cart.";
		  header('Location: ./');
		  exit();
		}
		else if(isset($_REQUEST['ratingvalue'])) 
		{
		  $productid = $_REQUEST['productid'];
		  $ratingvalue = $_REQUEST['ratingvalue'];
		  $results = $ratingsmodel->SetRating($productid, $ratingvalue, $ipaddress);
		  header('Location: ./');
		  exit();
		}
		$controller->view('home', $data);
	}
}