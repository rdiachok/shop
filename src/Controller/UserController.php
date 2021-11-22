<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{page}", name="user_list", requirements={"page"="\d+"})
     */
    public function list(int $page): Response
    {
       $entinyManager = $this->getDoctrine()->getManager();
        $user = new User();
        $user ->setEmail('rdiachok@gmail.com')
            -> setName('Roma')
            ->setNickname('Diachok')
            ->setAction('admin');

        $entinyManager->persist($user);
        $entinyManager->flush();

        return new Response('add user');
    }
    /**
     * @Route("/user/{slug}", name="user_show")
     */
    public function show(string $slug): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',

            'users' => $users,
        ]
        );
}
    /**
     * @Route("/user", name="user_index")
     */
    public function index(): Response
    {      
        return new Response('Hi User');
        
}

}