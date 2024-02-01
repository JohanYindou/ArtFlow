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

        // Users
        $users = [];
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
            $users[] = $user;
        }

        // Images
        $images = [];
        for ($i = 0; $i < 30; $i++) {
            $image = new Image();
            $image->setTitle($faker->sentence)
                ->setPath($faker->imageUrl())
                ->setCreatedAt($faker->dateTimeBetween('-1 year', 'now'))
                ->setUpdatedAt($faker->dateTimeBetween($image->getCreatedAt(), 'now'));

            // Associate an image with a user
            $user = $faker->randomElement($users);
            $image->setUser($user);

            $manager->persist($image);
            $images[] = $image;
        }

        // Likes
        for ($i = 0; $i < 60; $i++) {
            $like = new Like();
            $like->setCreatedAt($faker->dateTimeBetween('-1 year', 'now'));

            // Associate a like with a user and an image
            $user = $faker->randomElement($users);
            $image = $faker->randomElement($images);
            $like->setUser($user)->addImage($image);

            $manager->persist($like);
        }

        // Comments
        for ($i = 0; $i < 60; $i++) {
            $comment = new Comment();
            $comment->setContent($faker->sentence)
                ->setCreatedAt($faker->dateTimeBetween('-1 year', 'now'));

            // Associate a comment with a user and an image
            $user = $faker->randomElement($users);
            $image = $faker->randomElement($images);
            $comment->setUser($user)->setImage($image);

            $manager->persist($comment);
        }

        // Categories
        $categories = [];
        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->setName($faker->word)
                ->setCreatedAt($faker->dateTimeBetween('-1 year', 'now'));

            // Associate a category with multiple images
            for ($j = 0; $j < 1; $j++) {
                $image = $faker->randomElement($images);
                $category->setImage($image);
            }

            $manager->persist($category);
            $categories[] = $category;
        }

        // Tags
        $tags = [];
        for ($i = 0; $i < 5; $i++) {
            $tag = new Tag();
            $tag->setName($faker->word)
                ->setCreatedAt($faker->dateTimeBetween('-1 year', 'now'));

            // Associate a tag with multiple images
            for ($j = 0; $j < 3; $j++) {
                $image = $faker->randomElement($images);
                $tag->setImage($image);
            }

            $manager->persist($tag);
            $tags[] = $tag;
        }

        $manager->flush();
    }
}
