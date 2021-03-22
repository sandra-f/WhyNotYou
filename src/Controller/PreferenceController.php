<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PreferenceFormType;



class PreferenceController extends AbstractController
{
        /**
         * @Route("/new/{id<\d+>}",name="preference")
         */
        public function new(Request $request, int $id)
        {
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
               
             return $this->render('/preference/new.html.twig', ['preferenceForm'=>$form->createView()]);
        }
}
