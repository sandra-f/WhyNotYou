<?php
// src/Controller/UserController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserFormType;



class UserController extends AbstractController
{

        /**
         * @Route("/profil",name="profil")
         */
        public function new(Request $request)
        {
            
            $form = $this->createForm(UserFormType::class);
            $form->handleRequest($request);
               
             return $this->render('/profil/profil.html.twig', ['userForm'=>$form->createView()]);
        }

 
    /**
     * @Route("/edit/user", name="edit_user")
     */
    public function edit(Request $request, User $user)
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //UPDATE query en bdd
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('/profil/profil.html.twig', ['editForm'=>$form->createView()]);
    }


}