<?php
// src/Controller/UserController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;


class UserController extends AbstractController
{

    /**
     * Show user 
     */
     public function show(Request $request)
    {
      
        $repository = $this->getDoctrine()->getRepository(User::class);
        
        #Stocker dans $users tous les users
        $users = $repository->findAll();

    # return $this->render('chemin.html.twig',['users'=>$users]);

    }
   

    /**
     * Edit user 
     */
    public function edit(Request $request, User $user)
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //UPDATE query en bdd
            $this->getDoctrine()->getManager()->flush();
        }

        #return $this->render('chemin.html.twig', ['editForm'=>$form->createView()]);
    }

    /**
     * Delete user
     */
    public function delete(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        #Redirection vers la home page
        return $this->redirectToRoute('home');
    }

}