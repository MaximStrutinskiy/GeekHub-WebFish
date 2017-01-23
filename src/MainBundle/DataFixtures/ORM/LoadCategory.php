<?php
namespace MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use MainBundle\Entity\Category as Category;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadCategoryData
 *
 * @package MainBundle\DataFixtures\ORM
 */
class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $categories = [
            ['Art & Culture', 'Art, Music, Museum, Movie, Theatre'],
            ['Animals & Pets', 'Pets, Wild Life, Zoo'],
            ['Design & Photography', 'Design, Photography, Architecture'],
            ['Electronics', 'Mobile Store, Electronics Store, Video'],
            ['Holidays, Gifts & Flowers', 'Flowers, Holidays, Gifts'],
            ['Education & Books', 'Books, Education, Science'],
            ['Business & Services', 'Consulting, Industrial, Law'],
            ['Cars & Motorcycles', 'Cars, Motorcycles'],
            ['Sports, Outdoors & Travel', 'Sports, Travel, Hotels'],
            ['Fashion & Beauty', 'Fashion, Jewelry, Beauty'],
            ['Computers & Internet', 'Hosting, Software'],
            ['Food & Restaurant', 'Restaurant, Food & Drinks, Cafe'],
            ['Society & People', 'Personal Pages, Dating, Religion, Charity'],
            ['Home & Family', 'Wedding, Interior & Furniture, Kids & Children'],
            ['Entertainment, Games & Nightlife', 'Games, Night Club, Online Casino, Radio'],
            ['Real Estate', 'Real Estate Agency, Mortgage, Land Broker'],
            ['Medical (Healthcare)', 'Drug Store, Dentistry, Herbal'],
        ];

        //generate addReference($name) $name - name tag
        foreach ($categories as list($name, $description)) {
            $category = new Category();
            $category->setName($name);
            $category->setDescription($description);

            $manager->persist($category);
            $manager->flush();

            $this->addReference($name, $category);
        }
    }

    public function getOrder()
    {
        return 1;
    }
}
