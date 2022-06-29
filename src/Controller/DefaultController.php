<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Products;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use App\Form\RegistrationUserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(): Response
    {
        $product = $this->getDoctrine()->getRepository(Products::class)->findAll();

        return $this->render(
            'default/index.html.twig',
            [
                'text' => '',
                'product_result' => $product,
            ]
        );
    }

    /**
     * @Route ("/home", name="home")
     */
    public function home(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(Users::class)->findAll();
        dump($user);

        $user = new Users();
        $form = $this->createForm(RegistrationUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword($user, $form->get('password')
                    ->getData())
            );
            $user->setEmail($form->get('email')->getData());
            $user->setFirstName($form->get('firstName')->getData());
            $user->setLastName($form->get('lastName')->getData());
            $user->setRoles($form->get('roles')->getData());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('default/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
