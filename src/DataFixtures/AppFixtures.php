<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

use App\Entity\User;
use App\Entity\Image;
use App\Entity\Like;
use App\Entity\Comment;
use App\Entity\Category;
use App\Entity\Tag;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Création de plusieurs utilisateurs
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setUsername($faker->userName)
                ->setEmail($faker->email)
                ->setPassword('$2y$10$OorxAF.9ldO.I99Ygq.3neTHPWbsHYmwIJEzc/CbCH2IevLYxcVQ6')
                ->setDescription($faker->text)
                ->setProfilePicture($faker->imageUrl())
                ->setCreatedAt($faker->dateTimeBetween('-1 year', 'now'))
                ->setUpdatedAt($faker->dateTimeBetween($user->getCreatedAt(), 'now'));

            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }

        // Création de plusieurs images
        for ($i = 0; $i < 30; $i++) {
            $image = new Image();
            $image->setTitle($faker->sentence)
                ->setPath($faker->imageUrl())
                ->setCreatedAt($faker->dateTimeBetween('-1 year', 'now'))
                ->setUpdatedAt($faker->dateTimeBetween($image->getCreatedAt(), 'now'));

            // Associez une image à un utilisateur
            $user = $this->getReference('user_' . $faker->numberBetween(0, 9));
            $image->setUser($user);

            $manager->persist($image);
            $this->addReference('image_' . $i, $image);
        }

        // Création de plusieurs likes
        for ($i = 0; $i < 60; $i++) {
            $like = new Like();
            $like->setCreatedAt($faker->dateTimeBetween('-1 year', 'now'));

            // Associez un like à un utilisateur et une image
            $user = $this->getReference('user_' . $faker->numberBetween(0, 9));
            $image = $this->getReference('image_' . $faker->numberBetween(0, 9));
            $like->setUser($user)->addImage($image);

            $manager->persist($like);
        }

        // Création de plusieurs commentaires
        for ($i = 0; $i < 60; $i++) {
            $comment = new Comment();
            $comment->setContent($faker->sentence)
                ->setCreatedAt($faker->dateTimeBetween('-1 year', 'now'));

            // Associez un commentaire à un utilisateur et une image
            $user = $this->getReference('user_' . $faker->numberBetween(0, 9));
            $image = $this->getReference('image_' . $faker->numberBetween(0, 9));
            $comment->setUser($user)->setImage($image);

            $manager->persist($comment);
        }

        // Création de plusieurs catégories
        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->setName($faker->word)
                ->setCreatedAt($faker->dateTimeBetween('-1 year', 'now'));

            // Associez une catégorie à plusieurs images
            for ($j = 0; $j < 1; $j++) {
                $image = $this->getReference('image_' . $faker->numberBetween(0, 9));
                $category->setImage($image);
            }

            $manager->persist($category);
        }

        // Création de plusieurs tags
        for ($i = 0; $i < 5; $i++) {
            $tag = new Tag();
            $tag->setName($faker->word)
                ->setCreatedAt($faker->dateTimeBetween('-1 year', 'now'));

            // Associez un tag à plusieurs images
            for ($j = 0; $j < 3; $j++) {
                $image = $this->getReference('image_' . $faker->numberBetween(0, 9));
                $tag->setImage($image);
            }

            $manager->persist($tag);
        }

        $manager->flush();
    }
}
