<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Category;
use App\Models\Brand;

class CategoryBrandController extends Controller
{
    protected $categoryModel;
    protected $brandModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
        $this->brandModel = new Brand();
    }
    public function create()
    {
        
        $this->view('category_brand/created_form');
    }

    public function addCategoryOrBrand()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['data_type'])) {
                echo "Data type is missing.";
                return;
            }

            $dataType = $_POST['data_type'];
            $name = '';

            if ($dataType === 'category' && isset($_POST['category_name'])) {
                $name = $this->sanitizeInput($_POST['category_name']);
            } elseif ($dataType === 'brand' && isset($_POST['brand_name'])) {
                $name = $this->sanitizeInput($_POST['brand_name']);
            } else {
                echo "Name is missing.";
                return;
            }

            if (empty($name)) {
                echo "Name is required.";
                return;
            }

            if ($dataType === 'category') {
                if ($this->categoryModel->addCategory($name)) {
                    echo "Category added successfully!";
                } else {
                    echo "Failed to add category.";
                }
            } elseif ($dataType === 'brand') {
                if ($this->brandModel->addBrand($name)) {
                    echo "Brand added successfully!";
                } else {
                    echo "Failed to add brand.";
                }
            } else {
                echo "Invalid data type.";
            }
        } else {
            echo "Invalid request method.";
        }
    }

    protected function sanitizeInput($input)
    {
        return htmlspecialchars(strip_tags(trim($input)));
    }

}




