<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Category;
use App\Entity\User;
use App\Form\CategorieType;
use App\Form\EditUserType;
use App\Repository\UserRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends Controller
{


    /**
     * @Route("/utilisateurs", name="utilisateurs")
     * @param UserRepository $users
     * @return Response
     */
    public function usersList(UserRepository $users)
    {
        return $this->render("admin/users.html.twig", [
            'users' => $users->findAll()
        ]);
    }


    /**
     * @Route("/utilisateur/modifier/{id}", name="modifier_utilisateur")
     */
    public function editUser(User $users, Request $request)
    {
        $form = $this->createForm(EditUserType::class, $users);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($users);
            $manager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('admin_utilisateurs');
        }

        return $this->render('admin/edituser.html.twig', [
            'userForm' => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/categorie", name="create_article")
     */
    public function creaArticle(Category $category =null, Request $request, EntityManagerInterface $manager)
    {

        if(!$category){
            $category = new Category();
        }

        $form = $this -> createFormBuilder($category)
            ->add('titre')
            ->add('description')
            ->getForm();


        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){

                $manager->persist($category);
                $manager->flush();

                return $this->redirectToRoute('blog');
            }

        return $this->render('admin/createCategorie.html.twig',[
            'categorieForm' => $form->createView()
        ]);
    }
}