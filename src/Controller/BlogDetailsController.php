<?php

namespace App\Controller;

use App\Repository\BlogRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogDetailsController extends AbstractController
{
    #[Route('/blogdetails/{id}', name: 'app_blog_details')]
    public function index($id,UserRepository $userRepository,BlogRepository $blogRepository): Response
    {
        $blog=$blogRepository->findById($id);


        return $this->render('blog_details/index.html.twig', [
            'controller_name' => 'BlogDetailsController',
            'blog'=>$blog[0]
        ]);
    }
}
