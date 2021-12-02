<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class UserController extends AbstractController
{
    /**
     * @Route("/user/add/{id}", name="user_add", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function userAdd(int $id): Response
    {
        $entinyManager = $this->getDoctrine()->getManager();
        $userAdd = new User();
        $userAdd->setEmail('rdiachok@gmail.com')
            ->setName('Roma')
            ->setNickname('Diachok')
            ->setAction('admin');

        $entinyManager->persist($userAdd);
        $entinyManager->flush();

        return $this->render('user/indexAddUser.html.twig', [
                'user_name_first' => $userAdd->getName(),
                'user_last_name' => $userAdd->getNickname(),
                'user_action' => $userAdd->getAction(),
                'user_mail' => $userAdd->getEmail(),
            ]
        );
    }

    /**
     * @Route("/user/add/{id}", name="user_add_problem", methods={"GET"})
     */
    public function userAddProblem(string $id): Response
    {
        return $this->render('user/index.html.twig', [
                'user' => "Oops, you need input integer id user! You input ' . $id"
            ]
        );
    }

    /**
     * @Route("/user/get/{id}", name="user_get", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function userGet(int $id): Response
    {
        $userGet = $this->getDoctrine()->getRepository(User::class)->find($id);

        return $this->render('user/indexGetUser.html.twig', [
                'user_name_first' => $userGet->getName(),
                'user_last_name' => $userGet->getNickname(),
                'user_action' => $userGet->getAction(),
                'user_mail' => $userGet->getEmail(),
            ]
        );
    }

    /**
     * @Route("/user/get/{id}", name="user_get_error", methods={"GET"})
     */
    public function userGetError(string $id): Response
    {
        return $this->render('user/index.html.twig', [
                'user' => "Oops, you need input integer id user! You input ' . $id"
            ]
        );
    }

    /**
     * @Route("/user/getAll", name="user_get_all", methods={"GET"})
     */
    public function userGetAll(): Response
    {
        $userGet = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('user/indexGetAllUser.html.twig', [
                'user_all' => $userGet
            ]
        );
    }

    /**
     * @Route("/user/put/{id}", name="user_put", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function userPut(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->render('user/indexGetUser.html.twig', [
                    'user_name_first' => 'not found',
                    'user_last_name' => 'not found',
                    'user_action' => 'not found',
                    'user_mail' => 'not found',
                ]
            );
        }

        $user->setEmail('rdiachok@gmail.com')
            ->setName('Roma')
            ->setNickname('Diachok')
            ->setAction('admin');
        $entityManager->flush();

        return $this->render('user/indexGetUser.html.twig', [
                'user_name_first' => $user->getName(),
                'user_last_name' => $user->getNickname(),
                'user_action' => $user->getAction(),
                'user_mail' => $user->getEmail(),
            ]
        );
    }


    /**
     * @Route("/user/put/{id}", name="user_put_err", methods={"GET"})
     */
    public function userPutErr(string $id): Response
    {
        return $this->render('user/index.html.twig', [
                'user' => "Oops, you need input integer id user! You input ' . $id"
            ]
        );
    }

    /**
     * @Route("/user/delete/{id}", name="user_delete", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function userDelete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->render('user/index.html.twig', [
                'user' => "User was deleted from table ' . $id"
            ]
        );
    }


    /**
     * @Route("/user/delete/{id}", name="user_delete_err", methods={"GET"})
     */
    public function userDeleteErr(string $id): Response
    {
        return $this->render('user/index.html.twig', [
                'user' => "Oops, you need input integer id user! You input ' . $id"
            ]
        );
    }

    /**
     * @Route("/user", name="user_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
                'user' => "All you need to know near"
            ]
        );
    }
}
