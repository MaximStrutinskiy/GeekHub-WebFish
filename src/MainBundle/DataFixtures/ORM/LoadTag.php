<?php
namespace MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use MainBundle\Entity\Tag as Tag;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadTagData
 *
 * @package MainBundle\DataFixtures\ORM
 */
class LoadTagData extends AbstractFixture implements OrderedFixtureInterface {
  public function load(ObjectManager $manager) {
    //add you custom Tag in $tags array
    $tags = [
      //Browser.
      'Google Chrome',
      'Safari',
      'Firefox',
      'Internet Explorer',

      //Html.
      'HTML',
      'Jade',

      //CSS.
      'CSS',
      'LESS',
      'SASS',

      // Programming Languages.
      'Javascript',
      'Coffeescript',
      'Python',
      'Ruby',
      'PHP',
      'Go',
      'Objective-C',
      'Swift',
      'Java',

      // Frameworks.
      'Symfony3',
      'Meteor',
      'Node',
      'Ruby on Rails',
      'Django',
      'Ionic',
      'Cordova',
      'Bootstrap',
      'Foundation',
      'Wordpress',
      'Drupal',
      '.NET',
      'Angular',
      'Ember',
      'Backbone',

      // Libraries.
      'jQuery',
      'Underscore',

      // Databases.
      'MongoDB',
      'Redis',
      'PostgreSQL',
      'MySQL',
      'Oracle',
      'SQL Server',

      // Data formats.
      'JSON',
      'XML',
      'CSV',

      // Total (44)
    ];

    $count = 0;

    foreach ($tags as &$name) {
      $tag = new Tag();
      $tag->setName($name);

      $manager->persist($tag);
      $manager->flush();
      $count++;
      $this->addReference("tag{$count}", $tag);
    }
  }

  public function getOrder() {
    return 2;
  }
}
