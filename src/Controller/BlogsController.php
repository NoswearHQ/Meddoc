<?php

namespace App\Controller;

use App\Entity\data;
use App\Repository\BlogRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogsController extends AbstractController
{
    #[Route('/blogs', name: 'app_blogs')]
    public function index(BlogRepository $blogRepository,UserRepository $userRepository,PaginatorInterface $paginator,Request $request): Response
    {
    $Blog=$blogRepository->findAll();
        $criteria = $request->query->get('cat');

        $length = count($Blog);
        $test=new data();
        $data=null;
        for ($i = 0; $i<=$length-1; $i++) {
            $User=$userRepository->findbyID($Blog[$i]->getIdUser());
            $test->setUser($User);
            $test->setBlog($Blog[$i]);
            $data[]=$test;
            $test=new data();
        }
$pagination = $paginator->paginate(
$blogRepository->paginationQuery(),
    $request->query->get('page',1),
    4
);
        return $this->render('blogs/index.html.twig', [
            'controller_name' => 'BlogsController',
            'data'=>$data,
            'pagination' =>$pagination,
        ]);
    }
}
