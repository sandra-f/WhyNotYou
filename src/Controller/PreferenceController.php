<?php
// src/Controller/FormController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PreferenceFormType;



class PreferenceController extends AbstractController
{
        /**
         * @Route("/preference",name="preference")
         */
        public function new(Request $request)
        {
            
            $form = $this->createForm(PreferenceFormType::class);
            $form->handleRequest($request);
               
             return $this->render('/preference/preference.html.twig', ['preferenceForm'=>$form->createView()]);
        }
}
