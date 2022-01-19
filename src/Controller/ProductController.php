<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\NameProductSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AddProductType;

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

            return $this->render('product/index.html.twig', [
                    'form' => 'Main Page after add new Product',
                    'text' => 'Response of registration new product, his ID: ' . $product->getId(),
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
        $product = new Products();

        $form = $this->createForm(NameProductSearchType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productGetName = $product->getName();
            $product = $this->getDoctrine()
                ->getRepository(Products::class)
                ->findByExampleField($product->getName());

            if (!$product) {
                return $this->render('product/indexAddProduct.html.twig', [
                        'form' => $form->createView(),
                        'text' => 'Name product is not in table, Please check !'
                    ]
                );
            }

            return $this->render('product/resultNameSearch.html.twig', [
                    'product_result' => $product,
                    'product_set' => $productGetName,
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
     * @Route("/product/name/search/down/{slug}", name="product_sort_down")
     */
    public function productSortDown(string $slug): Response
    {
        $product = new Products();

        $product = $this->getDoctrine()
            ->getRepository(Products::class)
            ->findByExampleFieldNameAsc($slug);

        return $this->render('product/resultNameSearch.html.twig', [
                'product_result' => $product,
                'product_set' => $slug,
            ]
        );
    }

    /**
     * @Route("/product/maker/search/up/{slug}", name="product_maker_sort_up")
     */
    public function productMakerSortDown(string $slug): Response
    {
        $product = new Products();

        $product = $this->getDoctrine()
            ->getRepository(Products::class)
            ->findByExampleFieldMakerAsc($slug);

        return $this->render('product/resultNameSearch.html.twig', [
                'product_result' => $product,
                'product_set' => $slug,
            ]
        );
    }

    /**
     * @Route("/product/maker/search/down/{slug}", name="product_maker_sort_down")
     */
    public function productMakerSortUp(string $slug): Response
    {
        $product = new Products();

        $product = $this->getDoctrine()
            ->getRepository(Products::class)
            ->findByExampleFieldMakerDesc($slug);

        return $this->render('product/resultNameSearch.html.twig', [
                'product_result' => $product,
                'product_set' => $slug,
            ]
        );
    }

    /**
     * @Route("/product/price/search/up/{slug}", name="product_price_sort_up")
     */
    public function productPriceSortDown(string $slug): Response
    {
        $product = new Products();

        $product = $this->getDoctrine()
            ->getRepository(Products::class)
            ->findByExampleFieldPriceAsc($slug);

        return $this->render('product/resultNameSearch.html.twig', [
                'product_result' => $product,
                'product_set' => $slug,
            ]
        );
    }

    /**
     * @Route("/product/price/search/down/{slug}", name="product_price_sort_down")
     */
    public function productPriceSortUp(string $slug): Response
    {
        $product = new Products();

        $product = $this->getDoctrine()
            ->getRepository(Products::class)
            ->findByExampleFieldPriceDesc($slug);

        return $this->render('product/resultNameSearch.html.twig', [
                'product_result' => $product,
                'product_set' => $slug,
            ]
        );
    }

    /**
     * @Route("/product/name/search/name/up/{slug}", name="product_sort_up")
     */
    public function productSortUp(string $slug): Response
    {
        $product = new Products();

        $product = $this->getDoctrine()
            ->getRepository(Products::class)
            ->findByExampleFieldNameDesc($slug);

        return $this->render('product/resultNameSearch.html.twig', [
                'product_result' => $product,
                'product_set' => $slug,
            ]
        );
    }

    /**
     * @Route("/product/getAll", name="product_get_all", methods={"GET"})
     */
    public function productGetAll(): Response
    {
        $product = $this->getDoctrine()->getRepository(Products::class)->findAll();

        return $this->render('product/indexGetAllProduct.html.twig', [
                'product_result' => $product,
                'product_set' => '',
            ]
        );
    }

    /**
     * @Route("/product/getAll/name/asc", name="product_get_all_name_asc")
     */
    public function productGetAllNameAsc(): Response
    {
        $product = new Products();

        $product = $this->getDoctrine()
            ->getRepository(Products::class)
            ->findByExampleFieldAllNameAsc();

        return $this->render('product/indexGetAllProduct.html.twig', [
                'product_result' => $product,
                'product_set' => '',
            ]
        );
    }

    /**
     * @Route("/product/getAll/name/desc", name="product_get_all_name_desc")
     */
    public function productGetAllNameDesc(): Response
    {
        $product = new Products();

        $product = $this->getDoctrine()
            ->getRepository(Products::class)
            ->findByExampleFieldAllNameDesc();

        return $this->render('product/indexGetAllProduct.html.twig', [
                'product_result' => $product,
                'product_set' => '',
            ]
        );
    }

    /**
     * @Route("/product/getAll/maker/asc", name="product_get_all_maker_asc")
     */
    public function productGetAllMakerAsc(): Response
    {
        $product = new Products();

        $product = $this->getDoctrine()
            ->getRepository(Products::class)
            ->findByExampleFieldAllMakerAsc();

        return $this->render('product/indexGetAllProduct.html.twig', [
                'product_result' => $product,
                'product_set' => '',
            ]
        );
    }

    /**
     * @Route("/product/getAll/maker/desc", name="product_get_all_maker_desc")
     */
    public function productGetAllMakerDesc(): Response
    {
        $product = new Products();

        $product = $this->getDoctrine()
            ->getRepository(Products::class)
            ->findByExampleFieldAllMakerDesc();

        return $this->render('product/indexGetAllProduct.html.twig', [
                'product_result' => $product,
                'product_set' => '',
            ]
        );
    }

    /**
     * @Route("/product/getAll/price/asc", name="product_get_all_price_asc")
     */
    public function productGetAllPriceAsc(): Response
    {
        $product = new Products();

        $product = $this->getDoctrine()
            ->getRepository(Products::class)
            ->findByExampleFieldAllPriceAsc();

        return $this->render('product/indexGetAllProduct.html.twig', [
                'product_result' => $product,
                'product_set' => '',
            ]
        );
    }

    /**
     * @Route("/product/getAll/price/desc", name="product_get_all_price_desc")
     */
    public function productGetAllPriceDesc(): Response
    {
        $product = new Products();

        $product = $this->getDoctrine()
            ->getRepository(Products::class)
            ->findByExampleFieldAllPriceDesc();

        return $this->render('product/indexGetAllProduct.html.twig', [
                'product_result' => $product,
                'product_set' => '',
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
        return $this->render('product/index.html.twig', [
                'form' => 'Main product Page',
                'text' => '',
            ]
        );
    }
}

