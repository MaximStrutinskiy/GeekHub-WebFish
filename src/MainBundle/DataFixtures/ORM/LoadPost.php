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
class LoadPostData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        //category's in LoadCategoryData.php
        $count_categories = 7;

        //tags in LoadTagData.php
        $count_tags = 113;

        //users in LoadUserData.php

        // Generate random posts.
        $faker = Faker::create();
        $randomPosts = [];
        for ($i = 1; $i <= 100; $i++) {
            $var = [
                $faker->sentence($nbWords = 3, $variableNbWords = true),
                $faker->sentence($nbWords = 8, $variableNbWords = true),
                $faker->sentence($nbWords = 100, $variableNbWords = true),
                $faker->sentence($nbWords = 2000, $variableNbWords = true),
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
            $categoryIndex = rand(1, $count_categories);
            $post->setCategory($this->getReference("category{$categoryIndex}"));
            $tagIndex = array_rand(array_flip(range(1, $count_tags)), 7);
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
            [
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
            ],
            [
                'CMS Joomla',
                'CMS Joomla',
                'Joomla! is an award-winning content management system (CMS), which enables you to build Web sites and powerful online applications. Many aspects, including its ease-of-use and extensibility, have made Joomla! the most popular Web site software available. Best of all, Joomla! is an open source solution that is freely available to everyone.',
                'Joomla! is an award-winning content management system (CMS), which enables you to build Web sites and powerful online applications. Many aspects, including its ease-of-use and extensibility, have made Joomla! the most popular Web site software available. Best of all, Joomla! is an open source solution that is freely available to everyone.
                 Whats a content management system (CMS)?
                 A content management system is software that keeps track of every piece of content on your Web site, much like your local public library keeps track of books and stores them. Content can be simple text, photos, music, video, documents, or just about anything you can think of. A major advantage of using a CMS is that it requires almost no technical skill or knowledge to manage. Since the CMS manages all your content, you dont have to.
                 What are some real world examples of what Joomla! can do?
                 Joomla! is used all over the world to power Web sites of all shapes and sizes. For example:
                 Corporate Web sites or portals. Corporate intranets and extranets. Online magazines, newspapers, and publications. E-commerce and online reservations. Government applications. Small business Web sites. Non-profit and organizational Web sites. Community-based portals. School and church Web sites. Personal or family homepages. Who uses Joomla?. Millions of web sites are powered with Joomla. Discover examples of companies using Joomla! in the official Joomla! Showcase Directory.',
                1,
                2,
                'fixture_images/joomla.jpg',
            ],
            [
                'CMS ModX',
                'CMS ModX',
                'Articles is a Custom Resource Type for MODX 2.2 and later, that adds a custom Article Resource to MODX that streamlines blogging, commenting, archiving, tagging and other features of MODX into one unified interface.',
                'Articles is a Custom Resource Type for MODX 2.2 and later, that adds a custom Article Resource to MODX that streamlines blogging, commenting, archiving, tagging and other features of MODX into one unified interface. 
                Articles was written by Shaun McCormick as a blogging and news event Custom Resource Class, and was first released on November 29th, 2011. You can also view the Roadmap for future features to be added to Articles.
                It can be downloaded from within the MODX Revolution manager via Package Management, or from the MODX Extras Repository, here: http://modx.com/extras/package/articles. 
                Bugs and issue reporting can be done in the Articles Redmine project, found here: http://bugs.modx.com/projects/articles/issues. Also, a forum is setup for discussing Articles here: http://forums.modx.com/board?board=265',
                1,
                3,
                'fixture_images/modx.jpg',
            ],
            [
                'CMS Drupal',
                'CMS Drupal',
                'Drupal is content management software. It\'s used to make many of the websites and applications you use every day. Drupal has great standard features, like easy content authoring, reliable performance, and excellent security. But what sets it apart is its flexibility; modularity is one of its core principles. Its tools help you build the versatile, structured content that dynamic web experiences need.',
                'Drupal is content management software. It\'s used to make many of the websites and applications you use every day. Drupal has great standard features, like easy content authoring, reliable performance, and excellent security. But what sets it apart is its flexibility; modularity is one of its core principles. Its tools help you build the versatile, structured content that dynamic web experiences need.
                It\'s also a great choice for creating integrated digital frameworks. You can extend it with any one, or many, of thousands of add-ons. Modules expand Drupal\'s functionality. Themes let you customize your content\'s presentation. Distributions are packaged Drupal bundles you can use as starter-kits. Mix and match these components to enhance Drupal\'s core abilities. Or, integrate Drupal with external services and other applications in your infrastructure. No other content management software is this powerful and scalable.
                The Drupal project is open source software. Anyone can download, use, work on, and share it with others. It\'s built on principles like collaboration, globalism, and innovation. It\'s distributed under the terms of the GNU General Public License (GPL). There are no licensing fees, ever. Drupal will always be free.',
                1,
                4,
                'fixture_images/drupal.png',
            ],
            [
                'MotoCMS HTML Template',
                'MotoCMS HTML Template',
                'The name of the category speaks for itself. Most Popular Web Templates are determined by calculating the number of downloads. Nobody needs to be a genius to understand that being Most Popular, the web templates in this category must have something that makes them that successful, all those who downloaded them cannot be wrong. In other words, the website templates are the best of the best and you\'ll definitely want to buy one of them.',
                'The name of the category speaks for itself. Most Popular Web Templates are determined by calculating the number of downloads. Nobody needs to be a genius to understand that being Most Popular, the web templates in this category must have something that makes them that successful, all those who downloaded them cannot be wrong. In other words, the website templates are the best of the best and you\'ll definitely want to buy one of them.
                All our pre-made web designs were created by a team of professional web artists and can be used as a basis for fast and easy website development. Feel free to order customization from Template Tuning to save your time and efforts..
                The Drupal project is open source software. Anyone can download, use, work on, and share it with others. It\'s built on principles like collaboration, globalism, and innovation. It\'s distributed under the terms of the GNU General Public License (GPL). There are no licensing fees, ever. Drupal will always be free.',
                1,
                5,
                'fixture_images/MotoCMS.jpg',
            ],
            [
                'CMS OpenCart',
                'OpenCart',
                'The name of the category speaks for itself. Most Popular Web Templates are determined by calculating the number of downloads. Nobody needs to be a genius to understand that being Most Popular, the web templates in this category must have something that makes them that successful, all those who downloaded them cannot be wrong. In other words, the website templates are the best of the best and you\'ll definitely want to buy one of them.',
                'The name of the category speaks for itself. Most Popular Web Templates are determined by calculating the number of downloads. Nobody needs to be a genius to understand that being Most Popular, the web templates in this category must have something that makes them that successful, all those who downloaded them cannot be wrong. In other words, the website templates are the best of the best and you\'ll definitely want to buy one of them.
                All our pre-made web designs were created by a team of professional web artists and can be used as a basis for fast and easy website development. Feel free to order customization from Template Tuning to save your time and efforts..
                The Drupal project is open source software. Anyone can download, use, work on, and share it with others. It\'s built on principles like collaboration, globalism, and innovation. It\'s distributed under the terms of the GNU General Public License (GPL). There are no licensing fees, ever. Drupal will always be free.',
                1,
                6,
                'fixture_images/opencart.jpg',
            ],
            [
                'PrestaShop',
                'PrestaShop',
                'Merchant success has and always will be at the heart of all of our company efforts. By delivering the world’s most powerful and fully-featured ecommerce solution completely for free, PrestaShop enables people everywhere in the world to create and run a profitable online business.',
                'Merchant success has and always will be at the heart of all of our company efforts. By delivering the world’s most powerful and fully-featured ecommerce solution completely for free, PrestaShop enables people everywhere in the world to create and run a profitable online business.
                About PrestaShop
                PrestaShop provides more than 250,000 online store owners with the most powerful, dynamic and international ecommerce software enriched with hundreds of innovative tools to build and manage a successful online store at no cost. PrestaShop is simple, efficient and intuitive with unmatched power that enables users to thrive in a competitive market regardless of size, industry or revenue. By offering both, a flexible Open source and a user-friendly cloud-hybrid ecommerce solution completely for free, PrestaShop has removed the financial and technical barriers of starting an online business.
                Used in over 200 countries and partnered with the most renowned names in the industry, PrestaShop continues to revolutionize online retail with technology that increases sales and maximizes visibility. Working hand in hand with its growing community of more than 1,000,000 dedicated members, PrestaShop’s entrepreneurial team is made up of ecommerce enthusiasts that are committed to the success and profitability of their online merchants.
                Our vision for tomorrow
                Our vision is to revolutionize the ecommerce industry with a free, simple yet powerful solution that makes it possible for anyone, anywhere in the world, to build and manage a successful online store at no cost.
                Together with our dedicated international Community, we commit ourselves to the relentless pursuit of removing the financial and technical barriers of bringing great ideas to life. We will continuously strive to outpace the competitive landscape by tackling the challenges preventing online store owners from succeeding with refreshing and game-changing solutions.
                A family of innovators
                PrestaShop’s entrepreneurial team is made up of ecommerce enthusiasts that are committed to the success and profitability of online merchants. Headquartered in Paris and Miami, we work relentlessly to empower our users with a powerful software created by individuals who are passionate about making ecommerce better.',
                1,
                7,
                'fixture_images/presta.png',
            ],
        ];

        foreach ($var as $postArray) {
            array_push($customPosts, $postArray);
        }

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
            $tagIndex = array_rand(array_flip(range(1, $count_tags)), 7);
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
