<?php

namespace App\Controller;

use App\Repository\UserRepository;
use PhpParser\Comment\Doc;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(UserRepository $userRepository): Response
    {
        $Docteur=$userRepository->findAll();
        $Docteurs = array();
        if (sizeof($Docteur)>3)
        {
            for ($i = 0; $i < 3; $i++) {


                    $randomKey = array_rand($Docteur);
                    $Docteurs[] = $Docteur[$randomKey];
                    unset($Docteur[$randomKey]);

            }
        }else
        {
            $Docteurs=$Docteur;
        }



        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'Docteurs'=>$Docteurs
        ]);
    }
}
