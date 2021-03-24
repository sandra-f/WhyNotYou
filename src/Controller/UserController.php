<?php
// src/Controller/UserController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\PreferenceFormType;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;

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


        
        /**
         * @Route("/user/{id<\d+>}", name="show_user")
        */
        public function show(UserRepository $repo, int $id, Request $request):Response

        {        
                     
            $repository = $this->getDoctrine()->getRepository(User::class);

            $user = $repository->find($id);
            $match = $repo->findMatching($id);

            $repository = $this->getDoctrine()->getRepository(User::class);
            $user = $repository->find($id);

        $form = $this->createForm(PreferenceFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $table = array_merge($form['hobbies'],$form['valeurs']);
            // foreach ($table as $element) {
            //         $user->addItem($element);  
            // } 

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('user/userinterface.html.twig', ['utilisateur'=>$user, 'match'=>$match, 
                    'preferenceForm'=>$form->createView()]);
        }
        

        // /**
        //  * @Route("/user/match/{id<\d+>}}", name="show_match")
        // */
        // public function findMatching(UserRepository $repo, int $id)

        // {        
           
            
        // return $this->render('user/userinterface.html.twig', ['match'=>$match]);
        // }
    


}