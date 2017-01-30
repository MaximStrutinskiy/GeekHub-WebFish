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
class LoadTagData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        //add you custom Tag in $tags array
        $tags = [
            'Art',
            'Music',
            'Museum',
            'Movie',
            'Theatre',
            'Pets',
            'Wild Life',
            'Zoo',
            'Design',
            'Photography',
            'Architecture',
            'Electronics Store',
            'Video',
            'Flowers',
            'Holidays',
            'Gifts',
            'Books',
            'Education',
            'Science',
            'Consulting',
            'Industrial',
            'Law',
            'Cars',
            'Motorcycles',
            'Sports',
            'Travel',
            'Hotels',
            'Fashion',
            'Jewelry',
            'Beauty',
            'Hosting',
            'Software',
            'Restaurantc',
            'Food & Drinks',
            'Cafe',
            'Personal Pages',
            'Dating',
            'Religion',
            'Charity',
            'Wedding',
            'Interior & Furniture',
            'Kids & Children',
            'Games',
            'Night Club',
            'Online Casino',
            'Radio',
            'Real Estate Agency',
            'Mortgage',
            'Land Broker',
            'Drug Store',
            'Dentistry',
            'Herbal',
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

    public function getOrder()
    {
        return 2;
    }
}
