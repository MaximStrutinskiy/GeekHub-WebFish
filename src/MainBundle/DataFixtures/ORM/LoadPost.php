<?php
namespace MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use MainBundle\Entity\Post as Post;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Faker\Factory as Faker;

/**
 * Class LoadPostData
 *
 * @package MainBundle\DataFixtures\ORM
 */
class LoadPostData extends AbstractFixture implements OrderedFixtureInterface {

  public function load(ObjectManager $manager) {
    //category's in LoadCategoryData.php
    $count_categories = 113;

    //tags in LoadTagData.php
    $count_tags = 7;

    //users in LoadUserData.php


    // Generate random posts.
    $faker = Faker::create();
    $randomPosts = [];
    for ($i = 1; $i <= 100; $i++) {
      $var = [
        $faker->sentence($nbWords = 3, $variableNbWords = TRUE),
        $faker->sentence($nbWords = 8, $variableNbWords = TRUE),
        $faker->sentence($nbWords = 100, $variableNbWords = TRUE),
        $faker->sentence($nbWords = 2000, $variableNbWords = TRUE),
        '1',
        $faker->imageUrl($width = 1200, $height = 650),
      ];
      array_push($randomPosts, $var);
    }

    foreach ($randomPosts as list($shortTitle, $longTitle, $shortDescription, $longDescription, $postStatus, $image)) {
      $post = new Post();
      $post->setShortTitle($shortTitle);
      $post->setLongTitle($longTitle);
      $post->setShortDescriptions($shortDescription);
      $post->setLongDescriptions($longDescription);
      $moderIndex = rand(1, 2);
      $post->setUser($this->getReference("moder{$moderIndex}"));
      $post->setPostStatus($postStatus);
      $categoryIndex = rand(1, $count_tags);
      $post->setCategory($this->getReference("category{$categoryIndex}"));
      $tagIndex = array_rand(array_flip(range(1, $count_categories)), 7);
      /**@var Post $setTags */
      foreach ($tagIndex as $tag) {
        $post->addTag($this->getReference("tag{$tag}"));
      }
      $post->setPostImg($image);
      $post->setPostDate(new \DateTime);
      $manager->persist($post);
      $manager->flush();
    }

    // Custom posts.
    $customPosts = [];
    $var = [
      'CMS Wordpress',
      'CMS Wordpress',
      'WordPress started in 2003 with a single bit of code to enhance the typography of everyday writing and with fewer users than you can count on your fingers and toes. Since then it has grown to be the largest self-hosted blogging tool in the world, used on millions of sites and seen by tens of millions of people every day.',
      'WordPress started in 2003 with a single bit of code to enhance the typography of everyday writing and with fewer users than you can count on your fingers and toes. Since then it has grown to be the largest self-hosted blogging tool in the world, used on millions of sites and seen by tens of millions of people every day.
          Everything you see here, from the documentation to the code itself, was created by and for the community. WordPress is an Open Source project, which means there are hundreds of people all over the world working on it. (More than most commercial platforms.) It also means you are free to use it for anything from your recipe site to a Fortune 500 web site without paying anyone a license fee and a number of other important freedoms.
          About WordPress.org
          On this site you can download and install a software script called WordPress. To do this you need a web host who meets the minimum requirements and a little time. WordPress is completely customizable and can be used for almost anything. There is also a service called WordPress.com which lets you get started with a new and free WordPress-based blog in seconds, but varies in several ways and is less flexible than the WordPress you download and install yourself.
          What You Can Use WordPress For
          WordPress started as just a blogging system, but has evolved to be used as full content management system and so much more through the thousands of plugins and widgets and themes, WordPress is limited only by your imagination. (And tech chops.)
          Connect with the Community
          In addition to online resources like the forums and mailing lists a great way to get involved with WordPress is to attend or volunteer at a WordCamp, which are free or low-cost events that happen all around the world to gather and educate WordPress users, organized by WordPress users. Check out the website, there might be a WordCamp near you.
          A Little History
          WordPress was born out of a desire for an elegant, well-architectured personal publishing system built on PHP and MySQL and licensed under the GPLv2 (or later). It is the official successor of b2/cafelog. WordPress is fresh software, but its roots and development go back to 2001. It is a mature and stable product. We hope by focusing on user experience and web standards we can create a tool different from anything else out there.
          For a bit more about WordPress\' history check out the WordPress Wikipedia page or this page on our own Codex.',
      1,
      1,
      'fixture_images/wordpress.jpg',
    ];
    array_push($customPosts, $var);

    foreach ($customPosts as list($shortTitle, $longTitle, $shortDescription, $longDescription, $postStatus, $category, $image)) {
      $post = new Post();
      $post->setShortTitle($shortTitle);
      $post->setLongTitle($longTitle);
      $post->setShortDescriptions($shortDescription);
      $post->setLongDescriptions($longDescription);
      $moderIndex = rand(1, 2);
      $post->setUser($this->getReference("moder{$moderIndex}"));
      $post->setPostStatus($postStatus);
      $post->setCategory($this->getReference("category{$category}"));
      $tagIndex = array_rand(array_flip(range(1, $count_categories)), 7);
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

  public function getOrder() {
    return 4;
  }
}
