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
     * @Route("/user/edit/{id<\d+>}", name="edit_user")
     */
    public function edit(Request $request, User $user)
    {
        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //UPDATE query en bdd
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('/profil/edit.html.twig', ['editForm'=>$form->createView()]);
    }


}