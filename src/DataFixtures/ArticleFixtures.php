<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Articles;
use App\Entity\Comment;


class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');


        //3 catégories fakes
        for($i = 1;$i < 6; $i ++){
            $category  = new Category();
            $category -> setTitre($faker -> sentence())
                      -> setDescription($faker -> paragraph());
            $manager -> persist($category);



       for($j = 1; $j <= mt_rand(4,6); $j++) {
           $article = new Articles();

           $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';

           $article->setTitre($faker->sentence())
               ->setContent($content)
               ->setImage($faker->imageUrl())
               ->setCreatedAt($faker->DateTimeBetween('-6 months'))
               ->setCategory($category);

           $manager->persist($article);

           for ($k = 1; $k < mt_rand(4, 10); $k++) {
               $comment = new Comment();

               $content = '<p>' . join($faker->paragraphs(2), '</p><p>') . '</p>';

               $days  = (new \DateTime()) -> diff($article->getCreatedAt())->days;

               $comment->setAuteur($faker->name)
                       ->setContent($content)
                       ->setCreatedAt($faker->dateTimeBetween('-' . $days . ' days'))
                       ->setArticle($article);

               $manager -> persist($comment);
                }
            }
        }
        //Met en place dans la BDD php
        $manager->flush();
    }
}
