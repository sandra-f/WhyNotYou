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
         * @Route("/user/edit", name="edit_user")
         */
        public function edit(Request $request, ?User $user)
        {   
            if ($this->getUser() == null)
            {
                return $this->redirectToRoute('app_login');
            }

            $id = $this->getUser()->getId();
            $repository = $this->getDoctrine()->getRepository(User::class);

            $user = $repository->find($id);

            $form = $this->createForm(UserFormType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                //UPDATE query en bdd
                $this->getDoctrine()->getManager()->flush();
                
                $this->addFlash('success','Bravo, ton profil est mis à jour');
            }

            return $this->render('/profil/edit.html.twig', ['editForm'=>$form->createView()]);
        }


        
        /**
         * @Route("/user", name="show_user")
        */
        public function show(UserRepository $repo, Request $request):Response

        {   
            if ($this->getUser() == null)
            {
                return $this->redirectToRoute('app_login');
            }
    
            $id = $this->getUser()->getId();  
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

            $match = $repo->findMatching($id);
            $matchItems = $repo->findMatchItems($id);
            $userItemCount = $repo->countUserItems($id);

            // Création d'un tableau associatif par user_id
            $usersList = [];
            foreach ($match as $element)
            {
                $usersList[$element['user_target']] = $element;
            }

            // Compte le nombre d'items par utilisateur matché + tri décroissant
            $tab = [];
            foreach ($matchItems as $item)
            {   
                if (!isset($tab[$item['user_id']]))
                {
                    $tab[$item['user_id']] = 0;
                }
                $tab[$item['user_id']]++;
            }
            arsort($tab);

            // Calcul du pourcentage de matching
            $pourcent = [];
            foreach ($tab as $key => $element)
            {
                $calcul = round($tab[$key] * 100 / intval($userItemCount['nb']), 2);
                if ($calcul >= 25)
                {
                    $pourcent[$key] = $usersList[$key];
                    $pourcent[$key]['pourcentage'] = $calcul;
                }
                
            }
            
           
        

        return $this->render('user/userinterface.html.twig', ['utilisateur'=>$user, 'match'=>$pourcent, 'match_items'=>$matchItems, 
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