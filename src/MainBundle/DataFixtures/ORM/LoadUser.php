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
                'moder1',
                'moder1@moder.com',
                'moder1',
                'TRUE',
                ['ROLE_MODERATOR', 'ROLE_USER'],
            ],
            [
                'moder2',
                'moder2@moder.com',
                'moder2',
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

        foreach ($users as list($userName, $userEmail, $userPassword, $userEnabled, $userRole, )) {
            $user = new User();
            $user->setUsername($userName);
            $user->setEmail($userEmail);
            $user->setPlainPassword($userPassword);
            $user->setEnabled($userEnabled);

            /**@var User $setTags */
            foreach ($userRole as $userRoles) {
                $user->addRole($userRoles);
            }

            $user->setImg();

            $manager->persist($user);
            $manager->flush();

            $this->addReference($userName, $user);
        }
    }

    public function getOrder()
    {
        return 3;
    }
}
