<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FacetagramController extends AbstractController
{
#Route Home
public function home()
    {        
        return $this->render('home.html.twig'); 
    }
}