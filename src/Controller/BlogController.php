<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Articles;
use App\Entity\Category;
use App\Repository\ArticlesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class BlogController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Articles::class);
        $articles = $repo -> findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(){
        return $this->render("blog/home.html.twig");
    }




    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/blog/{id}/edit", name="blog_edit")
     * @Route("/blog/new", name="blog_create")
     */
    public function create(Articles $article = null ,Request $request, EntityManagerInterface $manager){

        if(!$article){
            $article = new Articles();
        }

        $form = $this -> createFormBuilder($article)
                      ->add('titre')
                      ->add('category',EntityType::class,[
                          'class' => Category::class,
                          'choice_label' => 'titre'
                      ])
                      ->add('content')
                      ->add('image')
                      ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!$article->getId()){
                $article -> setCreatedAt(new \DateTime());
            }
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('blog_show',[
                'id'=> $article->getId()]);
        }

        return $this -> render('blog/create.html.twig', [
            'formArticle' => $form -> createView()

        ]);
    }


    /**
     * @Route("/blog/{id}", name="blog_show")
     * @param Articles $article
     * @return Response
     */
    public function show(Articles $article, Request $request, EntityManagerInterface $manager){
        $comment = new Comment();
        $form = $this -> createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $comment->setCreatedAt(new \DateTime())
                    ->setArticle($article)
                    ->setAuteur($this->getUser()->getUsername());
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('blog_show',['id' => $article->getId()]);
        }

        return $this->render("blog/show.html.twig",
        [
            'article' => $article,
            'commentForm' => $form->createView()
        ]);
    }


}
