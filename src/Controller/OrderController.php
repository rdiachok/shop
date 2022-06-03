<?php

namespace App\Controller;

use App\Entity\OrderItems;
use App\Entity\Orders;
use App\Entity\Users;
use App\Form\AddOrderType;
use App\Form\OrderFindByDateType;
use App\Form\OrderSortingByFieldType;
use App\Form\OrderDownloadPDFType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\pdfServices;

class OrderController extends AbstractController
{
    const ORDER_PDF_ROUTE = '/order/orderInfo.html.twig';
    const ORDER_ITEMS_ROUTE = '/order/items.html.twig';
    const ORDER_PDF_NAME = 'order';
    const ORDER_PDF_NAME_ALL = 'allOrders';
    const ORDER_ITEMS_NAME = 'allOrderItems';

    /**
     * @Route("/order", name="order", methods={"GET", "POST"})
     */
    public function index(Request $request): Response
    {
        $orderGet = $this->getDoctrine()->getRepository(Orders::class)->findAll();

        $form = $this->createForm(OrderDownloadPDFType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('order_add_pdf');
        }

        return $this->render(
            'order/index.html.twig',
            [
                'order_result' => $orderGet,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/order/add/", name="order_add", methods={"GET", "POST"})
     */
    public function orderAdd(Request $request, pdfServices $pdfServices): Response
    {
        $order = new Orders();

        $form = $this->createForm(AddOrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->render(
                'order/indexAddOrder.html.twig',
                [
                    'form' => $form->createView(),
                    'text' => 'Order complite'
                ]
            );
        }

        return $this->render(
            'order/indexAddOrder.html.twig',
            [
                'form' => $form->createView(),
                'text' => 'Add some info about order!'
            ]
        );
    }

    /**
     * @Route("/order/add/pdf", name="order_add_pdf", methods={"GET", "POST"})
     */
    public function orderAddPDF(Request $request, pdfServices $pdfServices): Response
    {
        $rout = self::ORDER_PDF_ROUTE;

        $order = new Orders();

        $form = $this->createForm(AddOrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            //PDF render
            $orderGet = $this->getDoctrine()
                ->getRepository(Orders::class)
                ->findBy(['id' => $order->getId()]);

            $pdfServices->getServisesPDF($orderGet, $rout, $order->getId());

            return $this->render(
                'order/indexAddOrder.html.twig',
                [
                    'form' => $form->createView(),
                    'text' => 'Order generate to PDF'
                ]
            );
        }

        return $this->render(
            'order/indexAddOrder.html.twig',
            [
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
                return $this->render(
                    'order/indexAddOrder.html.twig',
                    [
                        'form' => $form->createView(),
                        'text' => 'Order is not in table, Please check !'
                    ]
                );
            }

            return $this->render(
                'order/resultSoldDateSearch.html.twig',
                [
                    'order_result' => $order,
                ]
            );
        }

        return $this->render(
            'order/indexAddOrder.html.twig',
            [
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

        return $this->render(
            'order/indexUpdateSomeOrder.html.twig',
            [
                'order_result' => $order,
                'order_set' => '',
            ]
        );
    }

    /**
     * @Route("/order/update/{id}", name="order_update_id", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function orderUpdateById(int $id, Request $request, pdfServices $pdfServices): Response
    {
        $rout = self::ORDER_PDF_ROUTE;

        $order = $this->getDoctrine()->getRepository(Orders::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(AddOrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            //PDF render
            $orderGet = $this->getDoctrine()
                ->getRepository(Orders::class)
                ->findBy(['id' => $order->getId()]);

            $pdfServices->getServisesPDF($orderGet, $rout, $order->getId());

            return $this->render(
                'order/indexUpdateSomeOrderById.html.twig',
                [
                    'form' => $form->createView(),
                ]
            );
        }

        return $this->render(
            'order/indexUpdateSomeOrderById.html.twig',
            [
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

        return $this->render(
            'order/indexDeleteSomeOrder.html.twig',
            [
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

        return $this->render(
            'order/indexDeleteSomeOrder.html.twig',
            [
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
            $order = $this->getDoctrine()
                ->getRepository(Orders::class)
                ->sortTableBySomeField($field, $sortBy);

            if (!$order) {
                return $this->render(
                    'order/indexAddOrder.html.twig',
                    [
                        'form' => $form->createView(),
                        'text' => 'Order is not in table, Please check !'
                    ]
                );
            }

            return $this->render(
                'order/sorting.html.twig',
                [
                    'form' => $form->createView(),
                    'order_result' => $order,
                ]
            );
        }

        return $this->render(
            'order/sorting.html.twig',
            [
                'form' => $form->createView(),
                'order_result' => $orderGet,
            ]
        );
    }
}
