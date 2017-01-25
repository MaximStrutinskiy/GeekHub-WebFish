<?php
namespace MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use MainBundle\Entity\User as User;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadUserData
 *
 * @package MainBundle\DataFixtures\ORM
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $users = [
            [
                'admin',
                'admin@admin.com',
                'admin',
                'TRUE',
                ['ROLE_SUPER_ADMIN', 'ROLE_USER'],
            ],
            [
                'moder',
                'moder@moder.com',
                'moder',
                'TRUE',
                ['ROLE_MODERATOR', 'ROLE_USER'],
            ],
            [
                'user1',
                'user1@user1.com',
                'user1',
                'TRUE',
                ['ROLE_USER'],
            ],
            [
                'user2',
                'user2@user2.com',
                'user2',
                'TRUE',
                ['ROLE_USER'],
            ],
            [
                'user3',
                'user3@user3.com',
                'user3',
                'TRUE',
                ['ROLE_USER'],
            ],
        ];

        foreach ($users as list($userName, $userEmail, $userPassword, $userEnabled, $userRole)) {
            $tag = new User();
            $tag->setUsername($userName);
            $tag->setEmail($userEmail);
            $tag->setPlainPassword($userPassword);
            $tag->setEnabled($userEnabled);

            /**@var User $setTags */
            foreach ($userRole as $userRoles) {
                $tag->addRole($userRoles);
            }

            $manager->persist($tag);
            $manager->flush();
        }
    }

    public function getOrder()
    {
        return 3;
    }
}
