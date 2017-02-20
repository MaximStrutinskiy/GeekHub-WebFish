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
            ['WordPress', 'Easily the most accessible and possibly the most commonly used, the strength of WordPress is in its quick installation and the massive user and developer community that results in a vast array of plugins and enhancements for the platform.'],
            ['Joomla','A quick trip to the Joomla website will reveal the claim that millions of websites are running on the software, and the reason for this is simple – it is extremely customizable, suitable for pretty much any purpose.'],
            ['ModX','You need little or no coding knowledge to use the best CMS applications, and ModX is a strong example of this. With over 100,000 websites ranging from enterprise-scale businesses to sole traders, ModX  is easy to use, allows non-technical staff to create content and affords various advantages such as using multiple styles on the same page.'],
            ['Drupal','A popular free and open source CMS, Drupal is often one of the first choices when building a new website.  Like many of the other tools listed here, Drupal can be scaled for personal blogs or enterprise mega-sites, and like WordPress there are thousands of modules that can be added to increase functionality.'],
            ['MotoCMS HTML Template','MotoCMS HTML templates are premium design works that look great and are extremely functional due to the feature-rich MotoCMS admin panel inside. This admin panel is used by thousands of people - website building rookies love it for its simplicity and seasoned web developers are fans of MotoCMS because it allows every little bit of website content to be edited directly from the admin panel.'],
            ['OpenCart', 'The OpenCart marketplace features 13000+ modules and themes to jump-start, grow and expand your business. You can find beautiful themes for just about any sector, service integrations, payment providers, shipping methods, social media, marketing, accounting, reporting, sales as well as language packs.'],
            ['PrestaShop', 'PrestaShop provides more than 250,000 online store owners with the most powerful, dynamic and international ecommerce software enriched with hundreds of innovative tools to build and manage a successful online store at no cost. PrestaShop is simple, efficient and intuitive with unmatched power that enables users to thrive in a competitive market regardless of size, industry or revenue. By offering both, a flexible Open source and a user-friendly cloud-hybrid ecommerce solution completely for free, PrestaShop has removed the financial and technical barriers of starting an online business.']
        ];

        //generate addReference($name) $name - name tag
        $count = 0;
        foreach ($categories as list($name, $description)) {
            $category = new Category();
            $category->setName($name);
            $category->setDescription($description);
            $manager->persist($category);
            $manager->flush();
            $count++;
            $this->addReference("category{$count}", $category);
        }
    }

    public function getOrder()
    {
        return 1;
    }
}
