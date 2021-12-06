<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/add/{id}", name="product_add", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function productAdd(int $id): Response
    {
        $entinyManager = $this->getDoctrine()->getManager();
        $productAdd = new Product();
        $productAdd->setName('milk')
            ->setCount('199')
            ->setFactory('CherkasuMilk')
            ->setPrice('30');

        $entinyManager->persist($productAdd);
        $entinyManager->flush();

        return $this->render('product/indexAddProduct.html.twig', [
                'product_name' => $productAdd->getName(),
                'product_count' => $productAdd->getCount(),
                'product_factory' => $productAdd->getFactory(),
                'product_price' => $productAdd->getPrice(),
            ]
        );
    }

    /**
     * @Route("/product/add/{id}", name="product_add_problem", methods={"GET"})
     */
    public function productAddProblem(string $id): Response
    {
        return $this->render('product/index.html.twig', [
                'product' => "Oops, you need input integer id product! You input ' . $id"
            ]
        );
    }

    /**
     * @Route("/product/get/{id}", name="product_get", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function productGet(int $id): Response
    {
        $productGet = $this->getDoctrine()->getRepository(Product::class)->find($id);

        return $this->render('product/indexGetProduct.html.twig', [
                'product_name' => $productGet->getName(),
                'product_count' => $productGet->getCount(),
                'product_factory' => $productGet->getFactory(),
                'product_price' => $productGet->getPrice(),
            ]
        );
    }

    /**
     * @Route("/product/get/{id}", name="product_get_error", methods={"GET"})
     */
    public function productGetError(string $id): Response
    {
        return $this->render('product/index.html.twig', [
                'product' => "Oops, you need input integer id product! You input ' . $id"
            ]
        );
    }

    /**
     * @Route("/product/getAll", name="product_get_all", methods={"GET"})
     */
    public function productGetAll(): Response
    {
        $productGet = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->render('product/indexGetAllProduct.html.twig', [
                'product_all' => $productGet
            ]
        );
    }

    /**
     * @Route("/product/put/{id}", name="product_put", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function productPut(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            return $this->render('product/indexGetProduct.html.twig', [
                    'product_name' => 'not found',
                    'product_count' => 'not found',
                    'product_price' => 'not found',
                    'product_factory' => 'not found',
                ]
            );
        }

        $product->setName('milk')
            ->setCount('199')
            ->setFactory('CherkasuMilk')
            ->setPrice('30');
        $entityManager->flush();

        return $this->render('product/indexGetProduct.html.twig', [
                'product_name' => $product->getName(),
                'product_count' => $product->getNickname(),
                'product_factory' => $product->getAction(),
                'product_price' => $product->getEmail(),
            ]
        );
    }


    /**
     * @Route("/product/put/{id}", name="product_put_err", methods={"GET"})
     */
    public function productPutErr(string $id): Response
    {
        return $this->render('product/index.html.twig', [
                'product' => "Oops, you need input integer id product! You input ' . $id"
            ]
        );
    }

    /**
     * @Route("/product/delete/{id}", name="product_delete", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function productDelete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->findOneBy(['id' => $id]);
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->render('product/index.html.twig', [
                'product' => "Product was deleted from table ' . $id"
            ]
        );
    }


    /**
     * @Route("/product/delete/{id}", name="product_delete_err", methods={"GET"})
     */
    public function productDeleteErr(string $id): Response
    {
        return $this->render('product/index.html.twig', [
                'product' => "Oops, you need input integer id product! You input ' . $id"
            ]
        );
    }

    /**
     * @Route("/product", name="product_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
                'product' => "All you need to know near"
            ]
        );
    }
}

