<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $productModel = new Product();
        $categoryModel = new Category();
        $brandModel = new Brand();  

        $perPage = 9;
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($currentPage - 1) * $perPage;
        $products = $productModel->getProductsWithPagination($perPage, $offset);
        $totalProducts = $productModel->getTotalProducts();
        $totalPages = ceil($totalProducts / $perPage);

        $categories = $categoryModel->getAllCategories();
        $brands = $brandModel->getAllBrands();

        

        $this->view('home/index', [
            'products' => $products,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function searchAndfilter()
    {
        $productModel = new Product();
        $categoryModel = new Category();
        $brandModel = new Brand();

        $perPage = 9;
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($currentPage - 1) * $perPage;

        $search = $_GET['search'] ?? '';
        $filterCategory = isset($_GET['category_id']) ? (array)$_GET['category_id'] : [];
        $filterBrand = isset($_GET['brand_id']) ? (array)$_GET['brand_id'] : [];
        $filterPrice = isset($_GET['price']) ? (array)$_GET['price'] : [];

        $products = $productModel->searchAndfilterProducts($search, $perPage, $offset, $filterCategory, $filterBrand, $filterPrice);
        $totalProducts = $productModel->countSearchandFilterResults($search, $filterCategory, $filterBrand, $filterPrice);
        $totalPages = ceil($totalProducts / $perPage);

        $categories = $categoryModel->getAllCategories();
        $brands = $brandModel->getAllBrands();

        $this->view('home/index', [
            'products' => $products,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'categories' => $categories,
            'brands' => $brands,
            'searchTerm' => $search,
            'filterCategory' => $filterCategory ?? [],
            'filterBrand' => $filterBrand ?? [],
            'filterPrice' => $filterPrice ?? [] 
        ]);
    }
    
}
