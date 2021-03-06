<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Form\AddOrderType;
use App\Form\OrderFindByDateType;
use App\Form\OrderSortingByFieldType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order", methods={"GET"})
     */
    public function index(): Response
    {
        $orderGet = $this->getDoctrine()->getRepository(Orders::class)->findAll();

        return $this->render('order/index.html.twig', [
                'order_result' => $orderGet,
                'order_set' => '',
            ]
        );
    }

    /**
     * @Route("/order/add/", name="order_add", methods={"GET", "POST"})
     */
    public function orderAdd(Request $request): Response
    {
        $order = new Orders();

        $form = $this->createForm(AddOrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->render('order/index.html.twig', [
                    'form' => 'Main Page after add new Order',
                    'text' => 'Response of registration new order, his ID: ' . $order->getId(),
                    'order_result' => '',
                ]
            );
        }

        return $this->render('order/indexAddOrder.html.twig', [
                'form' => $form->createView(),
                'text' => 'Add some info about order!'
            ]
        );
    }

    /**
     * @Route("/order/dateSold/search", name="order_date_sold_search", methods={"GET", "POST"})
     */
    public function orderDateSoldSearch(Request $request)
    {
        $form = $this->createForm(OrderFindByDateType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dateFrom = $form->get('dateFrom')->getData();
            $dateTo = $form->get('dateTo')->getData();

            $order = $this->getDoctrine()
                ->getRepository(Orders::class)
                ->findByExampleField($dateFrom, $dateTo);

            if (!$order) {
                return $this->render('order/indexAddOrder.html.twig', [
                        'form' => $form->createView(),
                        'text' => 'Order is not in table, Please check !'
                    ]
                );
            }

            return $this->render('order/resultSoldDateSearch.html.twig', [
                    'order_result' => $order,
                ]
            );
        }

        return $this->render('order/indexAddOrder.html.twig', [
                'form' => $form->createView(),
                'text' => 'Please input correct date!'
            ]
        );
    }

    /**
     * @Route("/order/update", name="order_update", methods={"GET"})
     */
    public function orderUpdate(): Response
    {
        $order = $this->getDoctrine()->getRepository(Orders::class)->findAll();

        return $this->render('order/indexUpdateSomeOrder.html.twig', [
                'order_result' => $order,
                'order_set' => '',
            ]
        );
    }

    /**
     * @Route("/order/update/{id}", name="order_update_id", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function orderUpdateById(int $id, Request $request): Response
    {
        $order = $this->getDoctrine()->getRepository(Orders::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(AddOrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();
            $order = $this->getDoctrine()->getRepository(Orders::class)->findAll();

            return $this->render('order/indexUpdateSomeOrder.html.twig', [
                    'order_result' => $order,
                    'order_set' => $id,
                ]
            );
        }

        return $this->render('order/indexUpdateSomeOrderById.html.twig', [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/order/delete", name="order_delete", methods={"GET"})
     */
    public function orderDelete(): Response
    {
        $order = $this->getDoctrine()->getRepository(Orders::class)->findAll();

        return $this->render('order/indexDeleteSomeOrder.html.twig', [
                'order_result' => $order,
                'order_set' => '',
            ]
        );
    }

    /**
     * @Route("/order/delete/{id}", name="order_delete_id", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function orderDeleteById(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $orderDelete = $entityManager->getRepository(Orders::class)->findOneBy(['id' => $id]);
        $entityManager->remove($orderDelete);
        $entityManager->flush();
        $order = $this->getDoctrine()->getRepository(Orders::class)->findAll();

        return $this->render('order/indexDeleteSomeOrder.html.twig', [
                'order_result' => $order,
                'order_set' => $id,
            ]
        );
    }

     /**
     * @Route("/order/sorting", name="order_sorting", methods={"GET", "POST"})
     */
    public function orderSorting(Request $request): Response
    {
        $orderGet = $this->getDoctrine()->getRepository(Orders::class)->findAll();
        $form = $this->createForm(OrderSortingByFieldType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $field = $form->get('field')->getData();
            $sortBy = $form->get('sort')->getData();
            $order= $this->getDoctrine()
                ->getRepository(Orders::class)
                ->sortTableBySomeField($field, $sortBy);

            if (!$order) {
                return $this->render('order/indexAddOrder.html.twig', [
                        'form' => $form->createView(),
                        'text' => 'Order is not in table, Please check !'
                    ]
                );
            }

            return $this->render('order/sorting.html.twig', [
                    'form' => $form->createView(),
                    'order_result' => $order,
                ]
            );
        }

        return $this->render('order/sorting.html.twig', [
                'form' => $form->createView(),
                'order_result' => $orderGet,
            ]
        );
    }
}


