<?php

namespace App\Controller;

use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

/**
 * Class UserController
 *
 * @Rest\Route("/api")
 * @package App\Controller
 */
class UserController extends FOSRestController
{
    /**
     * Create User.
     *
     * @Rest\Post("/user")
     * @param Request $request
     * @return View
     */
    public function postUserAction(Request $request)
    {
        $user = new User();
        $user->setUsername($request->get('username'));
        $user->setEmail($request->get('email'));
        $user->setFirstName($request->get('first_name'));
        $user->setLastName($request->get('last_name'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return View::create($user, Response::HTTP_CREATED);
    }

    /**
     * Get all users.
     *
     * @Rest\Get("/users")
     * @return View
     */
    public function getUsersAction()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return View::create($users, Response::HTTP_OK);
    }

    /**
     * Get a single user by id.
     *
     * @Rest\Get("/user/{id}")
     * @param User $user
     * @return View
     */
    public function getUserAction(User $user)
    {
        return View::create($user, Response::HTTP_OK);
    }

    /**
     * Delete user.
     *
     * @Rest\Delete("/user/{id}")
     * @param User $user
     * @return View
     */
    public function deleteUserAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}
