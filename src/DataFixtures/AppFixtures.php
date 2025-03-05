<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Account;
use App\Entity\Article;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr_FR');
        $accounts = [];

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
            $accounts[] = $account;
        }

        for($j = 0; $j < 100; $j++){
            $article = new Article();
            $article->setTitle($faker->sentence())
                    ->setContent($faker->text())
                    ->setCreateAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween("-6 months", "now")))
                    ->setAuthor($faker->randomElement($accounts));

            $manager->persist($article);
        }
        //Enregistrement en base de données
        $manager->flush();
    }
}
