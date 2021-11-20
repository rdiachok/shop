<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(): Response
    {
        
        $product = ['milk', 'chokolate', 'beer', 'fish'];

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',

            'product' => $product,
        ]);
    }
}
