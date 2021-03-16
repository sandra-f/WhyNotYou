<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * Login - Route
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        # retrouver une erreur d'authentification s'il y en a 
        $error = $authenticationUtils->getLastAuthenticationError();
        # retrouver le dernier identifiant de connexion utilisé
        $lastUsername = $authenticationUtils->getLastUsername();

        #return $this->render('chemin.html.twig', [
        #    'last_username' => $lastUsername,
        #    'error' => $error,]);
    }

    /**
     * Logout - Route
     */
    public function logout(): void
    {
        throw new \Exception('Erreur de connexion');
    }
}