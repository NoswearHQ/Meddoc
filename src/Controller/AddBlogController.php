<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\User;
use App\Form\BlogType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AddBlogController extends AbstractController
{
    #[Route('/addblog', name: 'app_add_blog')]
    public function index(Request $request ,EntityManagerInterface $entityManager,SluggerInterface $slugger,UserRepository $userRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('image')->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photo->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $photo->move(
                        $this->getParameter('blog_Imgs'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }
            $blog->setImage($newFilename);
            $user=$userRepository->findbyEmail($this->getUser()->getUserIdentifier());
            $blog->setDateArticle(date('d-m-y h:i:s'));
            $blog->setIdUser($user->getId());
            $entityManager->persist($blog);
            $entityManager->flush();

            return $this->redirectToRoute('app_blogs');
        }
        return $this->render('add_blog/index.html.twig', [
            'BlogForm' => $form->createView(),
        ]);
    }
}
