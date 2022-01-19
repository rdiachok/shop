<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Customer;

class CustomerController extends AbstractController
{
    /**
     * @Route("/customer/add/{id}", name="customer_add", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function customerAdd(int $id): Response
    {
        $entinyManager = $this->getDoctrine()->getManager();
        $customerAdd = new Customer();
        $customerAdd->setEmail('rdiachok@gmail.com')
            ->setName('Roma')
            ->setNickname('Diachok');

        $entinyManager->persist($customerAdd);
        $entinyManager->flush();

        return $this->render('customer/indexAddCustomer.html.twig', [
                'customer_name_first' => $customerAdd->getName(),
                'customer_last_name' => $customerAdd->getNickname(),
                'customer_mail' => $customerAdd->getEmail(),
            ]
        );
    }

    /**
     * @Route("/customer/add/{id}", name="customer_add_problem", methods={"GET"})
     */
    public function customerAddProblem(string $id): Response
    {
        return $this->render('customer/index.html.twig', [
                'customer' => "Oops, you need input integer id customer! You input ' . $id"
            ]
        );
    }

    /**
     * @Route("/customer/get/{id}", name="customer_get", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function customerGet(int $id): Response
    {
        $customerGet = $this->getDoctrine()->getRepository(Customer::class)->find($id);

        return $this->render('customer/indexGetCustomer.html.twig', [
                'customer_name_first' => $customerGet->getName(),
                'customer_last_name' => $customerGet->getNickname(),
                'customer_mail' => $customerGet->getEmail(),
            ]
        );
    }

    /**
     * @Route("/customer/get/{id}", name="customer_get_error", methods={"GET"})
     */
    public function customerGetError(string $id): Response
    {
        return $this->render('customer/index.html.twig', [
                'customer' => "Oops, you need input integer id customer! You input ' . $id"
            ]
        );
    }

    /**
     * @Route("/customer/getAll", name="customer_get_all", methods={"GET"})
     */
    public function customerGetAll(): Response
    {
        $customerGet = $this->getDoctrine()->getRepository(Customer::class)->findAll();

        return $this->render('customer/indexGetAllCustomer.html.twig', [
                'customer_all' => $customerGet
            ]
        );
    }

    /**
     * @Route("/customer/put/{id}", name="customer_put", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function customerPut(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $customer = $entityManager->getRepository(Customer::class)->find($id);

        if (!$customer) {
            return $this->render('customer/indexGetCustomer.html.twig', [
                    'customer_name_first' => 'not found',
                    'customer_last_name' => 'not found',
                    'customer_mail' => 'not found',
                ]
            );
        }

        $customer->setEmail('rdiachok@gmail.com')
            ->setName('Roma')
            ->setNickname('Diachok');
        $entityManager->flush();

        return $this->render('customer/indexGetCustomer.html.twig', [
                'customer_name_first' => $customer->getName(),
                'customer_last_name' => $customer->getNickname(),
                'customer_mail' => $customer->getEmail(),
            ]
        );
    }


    /**
     * @Route("/customer/put/{id}", name="customer_put_err", methods={"GET"})
     */
    public function customerPutErr(string $id): Response
    {
        return $this->render('customer/index.html.twig', [
                'customer' => "Oops, you need input integer id customer! You input ' . $id"
            ]
        );
    }

    /**
     * @Route("/customer/delete/{id}", name="customer_delete", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function customerDelete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $customer = $entityManager->getRepository(Customer::class)->findOneBy(['id' => $id]);
        $entityManager->remove($customer);
        $entityManager->flush();

        return $this->render('customer/index.html.twig', [
                'customer' => "Customer was deleted from table ' . $id"
            ]
        );
    }


    /**
     * @Route("/customer/delete/{id}", name="customer_delete_err", methods={"GET"})
     */
    public function customerDeleteErr(string $id): Response
    {
        return $this->render('customer/index.html.twig', [
                'customer' => "Oops, you need input integer id customer! You input ' . $id"
            ]
        );
    }

    /**
     * @Route("/customer", name="customer_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('customer/index.html.twig', [
                'customer' => "All you need to know near"
            ]
        );
    }
}

