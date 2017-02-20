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
      'Google Chrome',
      'Safari',
      'Firefox',
      'Internet Explorer',
      'HTML',
      'Jade',
      'CSS',
      'LESS',
      'SASS',
      'Javascript',
      'Coffeescript',
      'Python',
      'Ruby',
      'PHP',
      'Go',
      'Objective-C',
      'Swift',
      'Java',
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
      'jQuery',
      'Underscore',
      'MongoDB',
      'Redis',
      'PostgreSQL',
      'MySQL',
      'Oracle',
      'SQL Server',
      'JSON',
      'XML',
      'CSV',
      'Art',
      'Music',
      'Museum',
      'Movie',
      'Theatre',
      'Animals & Pets',
      'Pets',
      'Wild Life',
      'Zoo',
      'Design & Photography',
      'Design',
      'Photography',
      'Architecture',
      'Electronics',
      'Mobile Store',
      'Electronics Store',
      'Video',
      'Holidays',
      'Gifts & Flowers',
      'Flowers',
      'Holidays',
      'Gifts',
      'Education & Books',
      'Books',
      'Education',
      'Science',
      'Business & Services',
      'Consulting',
      'Industrial',
      'Law',
      'Cars & Motorcycles',
      'Cars',
      'Motorcycles',
      'Sports, Outdoors & Travel',
      'Sports',
      'Travel',
      'Hotels',
      'Fashion & Beauty',
      'Fashion',
      'Jewelry',
      'Beauty',
      'Computers & Internet',
      'Hosting',
      'Software',
      'Food & Restaurant',
      'Restaurant',
      'Food & Drinks',
      'Cafe',
      'Society & People',
      'Personal Pages',
      'Dating',
      'Religion',
      'Charity',
      'Home & Family',
      'Wedding',
      'Interior & Furniture',
      'Kids & Children',
      'Entertainment',
      'Games & Nightlife',
      'Games, Night Club',
      'Online Casino',
      'Radio',
      'Real Estate',
      'Real Estate Agency',
      'Mortgage',
      'Land Broker',
      'Medical (Healthcare)',
      'Drug Store',
      'Dentistry',
      'Herbal',

      // Total (113)
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
