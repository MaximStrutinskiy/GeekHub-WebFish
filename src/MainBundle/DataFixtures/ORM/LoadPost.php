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
class LoadPostData extends AbstractFixture implements OrderedFixtureInterface {

  /** @var  ContainerInterface */
  private $container;

  public function load(ObjectManager $manager) {

    //all category in LoadCategoryData.php
    //all tags in LoadTagData.php
    //all user in LoadUserData.php

    $faker = Faker::create();
    $postContent = [];

    $randomCategory = new MainController;
    $randomCategory->selectOneRandomCategory();

    for ($i = 1; $i <= 20; $i++) {
      $var = [
        $faker->sentence($nbWords = 3, $variableNbWords = TRUE),
        $faker->sentence($nbWords = 8, $variableNbWords = TRUE),
        $faker->sentence($nbWords = 20, $variableNbWords = TRUE),
        $faker->sentence($nbWords = 2000, $variableNbWords = TRUE),
        '1',
        $randomCategory,
        $faker->imageUrl($width = 1200, $height = 650),
        ['Flowers', 'Architecture'],
      ];

      array_push($postContent, $var);
    }


    foreach ($postContent as list($shortTitle, $longTitle, $shortDescription, $longDescription, $user, $postStatus, $category, $setTags, $image)) {
      $post = new Post();
      $post->setShortTitle($shortTitle);
      $post->setLongTitle($longTitle);
      $post->setShortDescriptions($shortDescription);
      $post->setLongDescriptions($longDescription);

            $post->setUser($user);

      $post->setPostStatus($postStatus);

            $post->setCategory($this->getReference($category));

            /**@var Post $setTags */
            foreach ($setTags as $tagArray) {
                $post->addTag($this->getReference($tagArray));
            }

      $post->setPostImg($image);
      $post->setPostDate(new \DateTime);
      $manager->persist($post);
      $manager->flush();
    }
  }

  public function getOrder() {
    return 4;
  }


  /**
   * Sets the Container. Need it to create new User from fos_user.user_manager
   * service
   *
   * @param ContainerInterface|null $container A ContainerInterface instance or
   *   null
   */
  public function setContainer(ContainerInterface $container = NULL) {
    $this->container = $container;
  }
}
