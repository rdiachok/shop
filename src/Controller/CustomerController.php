<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /**
     * @Route("/customer", name="customer")
     */
    public function index(): Response
    {
        $customers = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('customer/index.html.twig', [
                'controller_name' => 'CustomerController',
                'customer' => $customers,
            ]
        );
    }
}
