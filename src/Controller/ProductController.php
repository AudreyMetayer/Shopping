<?php


namespace App\Controller;


use App\Model\CategoryManager;
use App\Model\ProductManager;

class ProductController extends AbstractController
{

    public function allProduct()
    {
        $productManager = new ProductManager();
        $products = $productManager->all();
        return $this->twig->render('/Home/list.html.twig', [
            'products' => $products,
        ]);
    }

    public function new()
    {
        $category = new ProductManager();
        $categories = $category->selectAllCategories();
        return $this->twig->render('/Home/category.html.twig', [
            'categories' => $categories
        ]);

    }

    public function add()
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAll();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $productManager = new ProductManager();
            $item = [
                'name' => $_POST['name'],
                'category' => $_POST['category'],

            ];
            $productManager->insert($item);
            header('Location: /product/allproduct');
        }
        return $this->twig->render('/add.html.twig', [
            'categories' => $categories,
        ]);


    }
}