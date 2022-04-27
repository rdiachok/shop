<?php

namespace App\Controller;

use App\Form\EmailUserSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Users;
use App\Form\AddUserType;

class UserController extends AbstractController
{
    /**
     * @Route("/user/add/", name="user_add", methods={"GET", "POST"})
     */
    public function userAdd(Request $request): Response
    {
        $user = new Users();

        $form = $this->createForm(AddUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->render('user/index.html.twig', [
                    'form' => 'Main Page after add new User',
                    'text' => 'Response of registration new user, his ID: ' . $user->getId(),
                ]
            );
        }

        return $this->render('user/indexAddUser.html.twig', [
                'form' => $form->createView(),
                'text' => 'Add some info about yourself!'
            ]
        );
    }

    /**
     * @Route("/user/email/search", name="user_email_search", methods={"GET", "POST"})
     */
    public function userEmailSearch(Request $request): Response
    {
        $user = new Users();

        $form = $this->createForm(EmailUserSearchType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getDoctrine()
                ->getRepository(Users::class)
                ->findByExampleField($user->getEmail());

            if (!$user) {
                return $this->render('user/indexAddUser.html.twig', [
                        'form' => $form->createView(),
                        'text' => 'Email is not in table, Please check !'
                    ]
                );
            }

            return $this->render('user/resultEmailSearch.html.twig', [
                    'user_result' => $user,
                    'text' => 'Some info'
                ]
            );
        }

        return $this->render('user/indexAddUser.html.twig', [
                'form' => $form->createView(),
                'text' => 'Please input correct email!'
            ]
        );
    }

    /**
     * @Route("/user/action/down", name="user_sort_down", methods={"GET"})
     */
    public function userActionSortDown(): Response
    {
        $user = new Users();

        $user = $this->getDoctrine()
            ->getRepository(Users::class)
            ->sortByActionDown();

        return $this->render('user/indexGetAllUser.html.twig', [
                'user_result' => $user,
                'user_set' => '',
            ]
        );
    }

    /**
     * @Route("/user/action/up", name="user_sort_up", methods={"GET"})
     */
    public function userActionSortUp(): Response
    {
        $user = new Users();

        $user = $this->getDoctrine()
            ->getRepository(Users::class)
            ->sortByActionUp();

        return $this->render('user/indexGetAllUser.html.twig', [
                'user_result' => $user,
                'user_set' => '',
            ]
        );
    }

    /**
     * @Route("/user/getAll", name="user_get_all", methods={"GET"})
     */
    public function userGetAll(): Response
    {
        $userGet = $this->getDoctrine()->getRepository(Users::class)->findAll();

        return $this->render('user/indexGetAllUser.html.twig', [
                'user_result' => $userGet,
                'user_set' => '',
            ]
        );
    }

    /**
     * @Route("/user/update", name="user_update", methods={"GET"})
     */
    public function userUpdate(): Response
    {
        $user = $this->getDoctrine()->getRepository(Users::class)->findAll();

        return $this->render('user/indexUpdateSomeUser.html.twig', [
                'user_result' => $user,
                'user_set' => '',
            ]
        );
    }

    /**
     * @Route("/user/update/{id}", name="user_update_id", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function userUpdateById(int $id, Request $request): Response
    {
        $user = $this->getDoctrine()->getRepository(Users::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(AddUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $user = $this->getDoctrine()->getRepository(Users::class)->findAll();

            return $this->render('user/indexUpdateSomeUser.html.twig', [
                    'user_result' => $user,
                    'user_set' => $id,
                ]
            );
        }

        return $this->render('user/indexUpdateSomeUserById.html.twig', [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/user/delete/{id}", name="user_delete_id", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function userDeleteById(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $userDelete = $entityManager->getRepository(Users::class)->findOneBy(['id' => $id]);
        $entityManager->remove($userDelete);
        $entityManager->flush();
        $user = $this->getDoctrine()->getRepository(Users::class)->findAll();

        return $this->render('user/indexDeleteSomeUser.html.twig', [
                'user_result' => $user,
                'user_set' => $id,
            ]
        );
    }

    /**
     * @Route("/user/delete", name="user_delete", methods={"GET"})
     */
    public function userDelete(): Response
    {
        $user = $this->getDoctrine()->getRepository(Users::class)->findAll();

        return $this->render('user/indexDeleteSomeUser.html.twig', [
                'user_result' => $user,
                'user_set' => '',
            ]
        );
    }

    /**
     * @Route("/user", name="user_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
                'form' => 'Main user page',
                'text' => '',
            ]
        );
    }
}
