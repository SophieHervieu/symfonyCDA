<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Account;
use App\Entity\Article;
use App\Entity\Category;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr_FR');
        $accounts = [];
        $categories = [];

        for($i = 0; $i < 50; $i++) {
            //Ajouter un compte
            $account = new Account();
            $account->setFirstname($faker->firstName())
                    ->setLastname($faker->lastName())
                    ->setEmail($faker->email())
                    ->setPassword($faker->password())
                    ->setRoles("ROLE_USER");

            //Ajout en cache
            $manager->persist($account);
            //Stockage de chaque compte dans un tableau accounts
            $accounts[] = $account;
        }

        for($k = 0; $k < 30; $k++){
            $category = new Category();
            $category->setName($faker->word());
            
            $manager->persist($category);

            $categories[] = $category;
        }

        for($j = 0; $j < 100; $j++){
            $newCategories = $faker->randomElements($categories, 3);
            $article = new Article();
            $article->setTitle($faker->sentence())
                    ->setContent($faker->text())
                    ->setCreateAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween("-6 months", "now")))
                    ->setAuthor($faker->randomElement($accounts))
                    ->addCategory($newCategories[0])
                    ->addCategory($newCategories[1])
                    ->addCategory($newCategories[2]);

            $manager->persist($article);

            $categories[] = $category;
        }

        //Enregistrement en base de données
        $manager->flush();
    }
}
