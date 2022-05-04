<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\SearchProducteByNameType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AddProductType;
use App\Form\ProductSortingByFieldType;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/add/", name="product_add")
     */
    public function productAdd(Request $request): Response
    {
        $product = new Products();

        $form = $this->createForm(AddProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            $productAll = $this->getDoctrine()->getRepository(Products::class)->findAll();

            return $this->render('product/index.html.twig', [
                    'form' => 'Main Page after add new Product',
                    'text' => 'Response of registration new product, his ID: ' . $product->getId(),
                    'product_result' => $productAll,
                ]
            );
        }

        return $this->render('product/indexAddProduct.html.twig', [
                'form' => $form->createView(),
                'text' => 'Add some info about product!'
            ]
        );
    }

    /**
     * @Route("/product/name/search", name="product_name_search")
     */
    public function productNameSearch(Request $request): Response
    {
        $form = $this->createForm(SearchProducteByNameType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $this->getDoctrine()
                ->getRepository(Products::class)
                ->findByExampleField($form->get('name')->getData());

            if (!$product) {
                return $this->render('product/indexAddProduct.html.twig', [
                        'form' => $form->createView(),
                        'text' => 'Name product is not in table, Please check !'
                    ]
                );
            }

            return $this->render('product/resultNameSearch.html.twig', [
                    'product_result' => $product,
                    'product_set' => '',
                ]
            );
        }

        return $this->render('product/indexAddProduct.html.twig', [
                'form' => $form->createView(),
                'text' => 'Please input correct name product'
            ]
        );
    }

    /**
     * @Route("/product/update", name="product_update", methods={"GET"})
     */
    public function productUpdate(): Response
    {
        $product = $this->getDoctrine()->getRepository(Products::class)->findAll();

        return $this->render('product/indexUpdateSomeProduct.html.twig', [
                'product_result' => $product,
                'product_set' => '',
            ]
        );
    }

    /**
     * @Route("/product/update/{id}", name="product_update_id", requirements={"id"="\d+"})
     */
    public function productUpdateById(int $id, Request $request): Response
    {
        $product = $this->getDoctrine()->getRepository(Products::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(AddProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            $product = $this->getDoctrine()->getRepository(Products::class)->findAll();

            return $this->render('product/indexUpdateSomeProduct.html.twig', [
                    'product_result' => $product,
                    'product_set' => $id,
                ]
            );
        }

        return $this->render('product/indexUpdateSomeProducteById.html.twig', [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/product/delete/{id}", name="product_delete_id", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function productDeleteById(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $productDelete = $entityManager->getRepository(Products::class)->findOneBy(['id' => $id]);
        $entityManager->remove($productDelete);
        $entityManager->flush();
        $product = $this->getDoctrine()->getRepository(Products::class)->findAll();

        return $this->render('product/indexDeleteSomeProduct.html.twig', [
                'product_result' => $product,
                'product_set' => $id,
            ]
        );
    }

    /**
     * @Route("/product/delete", name="product_delete", methods={"GET"})
     */
    public function productDelete(): Response
    {
        $product = $this->getDoctrine()->getRepository(Products::class)->findAll();

        return $this->render('product/indexDeleteSomeProduct.html.twig', [
                'product_result' => $product,
                'product_set' => '',
            ]
        );
    }

    /**
     * @Route("/product", name="product_index", methods={"GET"})
     */
    public function index(): Response
    {
        $product = $this->getDoctrine()->getRepository(Products::class)->findAll();

        return $this->render('product/index.html.twig', [
                'form' => 'Main product Page',
                'text' => '',
                'product_result' => $product,
            ]
        );
    }

    /**
     * @Route("/product/sorting", name="product_sorting", methods={"GET", "POST"})
     */
    public function productSorting(Request $request): Response
    {
        $productGet = $this->getDoctrine()->getRepository(Products::class)->findAll();
        $form = $this->createForm(ProductSortingByFieldType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $field = $form->get('field')->getData();
            $sortBy = $form->get('sort')->getData();
            $product= $this->getDoctrine()
                ->getRepository(Products::class)
                ->sortTableBySomeField($field, $sortBy);

            if (!$product) {
                return $this->render('product/indexAddProduct.html.twig', [
                        'form' => $form->createView(),
                        'text' => 'Email is not in table, Please check !'
                    ]
                );
            }

            return $this->render('product/sorting.html.twig', [
                    'form' => $form->createView(),
                    'product_result' => $product,
                ]
            );
        }

        return $this->render('product/sorting.html.twig', [
                'form' => $form->createView(),
                'product_result' => $productGet,
            ]
        );
    }
}

