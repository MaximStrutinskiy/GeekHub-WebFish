<?php
namespace MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use MainBundle\Controller\MainController;
use MainBundle\Entity\Post as Post;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Faker\Factory as Faker;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadPostData
 *
 * @package MainBundle\DataFixtures\ORM
 */
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
                $faker->sentence($nbWords = 100, $variableNbWords = true),
                $faker->sentence($nbWords = 2000, $variableNbWords = true),
                '1',
                $faker->imageUrl($width = 1200, $height = 650),
            ];

            array_push($postContent, $var);
        }


        foreach ($postContent as list($shortTitle, $longTitle, $shortDescription, $longDescription, $postStatus, $image)) {
            $post = new Post();
            $post->setShortTitle($shortTitle);
            $post->setLongTitle($longTitle);
            $post->setShortDescriptions($shortDescription);
            $post->setLongDescriptions($longDescription);

            $moderIndex = rand(1, 2);
            $post->setUser($this->getReference("moder{$moderIndex}"));

            $post->setPostStatus($postStatus);

            $categoryIndex = rand(1, 17);
            $post->setCategory($this->getReference("category{$categoryIndex}"));

            $tagIndex = array_rand(array_flip(range(1, 51)), 4);
            /**@var Post $setTags */
            foreach ($tagIndex as $tag) {
                $post->addTag($this->getReference("tag{$tag}"));
            }

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
