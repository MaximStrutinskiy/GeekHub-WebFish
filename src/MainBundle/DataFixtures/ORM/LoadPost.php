<?php
namespace MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use MainBundle\Entity\Post as Post;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Faker\Factory as Faker;

class LoadPostData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        //all category in LoadCategoryData.php
        //all tags in LoadTagData.php
        //all user in LoadUserData.php

        $faker = Faker::create();

        $postContent = [];

        for ($i = 1; $i <= 20; $i++) {
            $var = [
                $faker->sentence($nbWords = 3, $variableNbWords = true),
                $faker->sentence($nbWords = 8, $variableNbWords = true),
                $faker->sentence($nbWords = 20, $variableNbWords = true),
                $faker->sentence($nbWords = 2000, $variableNbWords = true),
                '1',
                $query,
                $faker->imageUrl($width = 1200, $height = 650),
            ];

            array_push($postContent, $var);
        }


        foreach ($postContent as list($shortTitle, $longTitle, $shortDescription, $longDescription, $category, $postStatus, $image)) {
            $post = new Post();
            $post->setShortTitle($shortTitle);
            $post->setLongTitle($longTitle);
            $post->setShortDescriptions($shortDescription);
            $post->setLongDescriptions($longDescription);

//            $post->setUser($user);

            $post->setPostStatus($postStatus);

            $post->setCategory($this->getReference($category));

//            /**@var Post $setTags */
//            foreach ($setTags as $tagArray) {
//                $post->addTag($this->getReference($tagArray));
//            }

            $post->setPostImg($image);
            $post->setPostDate(new \DateTime);
            $manager->persist($post);
            $manager->flush();
        }
    }

    public function getOrder()
    {
        return 4;
    }
}