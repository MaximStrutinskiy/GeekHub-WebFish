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


  public function load(ObjectManager $manager) {

    //all category in LoadCategoryData.php
    //all tags in LoadTagData.php
    //all user in LoadUserData.php

    $faker = Faker::create();
    $postContent = [];

    $userRepository = $manager
      ->getRepository('MainBundle:User')
      ->createQueryBuilder('u')
      ->where('u.role LIKE :name')
      ->setParameter('name', '%"' . 'ROLE_MODERATOR' . '"%')
      ->orderBy('u.id', 'RAND')
      ->setMaxResults(1)
    ;

//    $tagRepository = $manager->get('doctrine')->getManager();

    for ($i = 1; $i <= 20; $i++) {
      $var = [
        $faker->sentence($nbWords = 3, $variableNbWords = TRUE),
        $faker->sentence($nbWords = 8, $variableNbWords = TRUE),
        $faker->sentence($nbWords = 20, $variableNbWords = TRUE),
        $faker->sentence($nbWords = 2000, $variableNbWords = TRUE),
        $userRepository,
        '1',
        'Art & Culture',
        $faker->imageUrl($width = 1200, $height = 650),
        ['Flowers'],
      ];

      array_push($postContent, $var);
    }


    foreach ($postContent as list($shortTitle, $longTitle, $shortDescription, $longDescription, $user, $postStatus, $category, $image, $setTags)) {
      $post = new Post();
      $post->setShortTitle($shortTitle);
      $post->setLongTitle($longTitle);
      $post->setShortDescriptions($shortDescription);
      $post->setLongDescriptions($longDescription);

      $post->setUser($this->getReference($user));
      $post->setPostStatus($postStatus);
      $post->setCategory($this->getReference($category));

      /**@var Post $setTags */
      foreach ($setTags as $tag) {
        $post->addTag($this->getReference($tag));
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
}
