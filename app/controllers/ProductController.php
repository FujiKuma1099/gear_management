<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Product;


class ProductController extends Controller
{
    public function create() 
    {
        $this->view('products/created_form');
    }

    public function addProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = 
            [
                'name' => $_POST['name'],
                'category_id' => $_POST['category_id'],
                'brand_id' => $_POST['brand_id'],
                'price' => $_POST['price'],
                'stock' => $_POST['stock'],
                'description' => $_POST['description'],
                'imagefile' => file_get_contents($_FILES['imagefile']['tmp_name'])
            ];
            $productModel = new Product();
            if ($productModel->addProduct($data)) {
                echo "Product added successfully!";
                header('Location:  /gear_management/public/home');
                exit();
            } else {
                echo "Failed to add product.";
            }
        }
    }

    public function showProduct($id) 
    {
        $productModel = new Product();
        $product = $productModel->getProductById($id);
        if ($product) {
            $this->view('products/show', ['product' => $product]);
        }
        else {
            echo "Product not found.";
        }
    }

    public function update($id)
    {
        $productModel = new Product();
        $product = $productModel->getProductById($id);
        if ($product) {
            $this->view('products/updated_form', ['product' => $product]);
        } else {
            echo "Product not found.";
        }
    }

    public function updateProduct($id)
    {
        $productModel = new Product();
        $existingProduct = $productModel->getProductById($id);

        $imagefile = (!empty($_FILES['imagefile']['tmp_name']) && $_FILES['imagefile']['error'] === 0)
            ? file_get_contents($_FILES['imagefile']['tmp_name'])
            : $existingProduct['imagefile'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'category_id' => $_POST['category'],
                'brand_id' => $_POST['brand'],
                'price' => $_POST['price'],
                'stock' => $_POST['stock'],
                'description' => $_POST['description'],
                'imagefile' => $imagefile
            ];

            if ($productModel->updateProduct($id, $data)) {
                header("Location: /gear_management/public/home");
                exit();
            } else {
                echo "Failed to update product.";
            }
        }
    }

    public function deleteProduct($id)
    {
        $productModel = new Product();
        if ($productModel->deleteProduct($id)) {
            echo "Product deleted successfully!";
        } else {
            echo "Failed to delete product.";
        }
    }

   
}