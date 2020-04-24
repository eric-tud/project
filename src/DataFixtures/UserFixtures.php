<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;


class UserFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        // create objects
        $userUser = $this->createUser('user', 'user', 'ROLE_USER');
        $userHead = $this->createUser('head', 'head', 'ROLE_HEAD');
        $userAdmin = $this->createUser('admin', 'admin', 'ROLE_ADMIN');

        // add to DB queue
        $manager->persist($userUser);
        $manager->persist($userHead);
        $manager->persist($userAdmin);

        // send query to DB
        $manager->flush();

    }
    private function createUser($username, $plainPassword, $role):User
    {
        $user = new User();
        $user->setUsername($username);
        $user->setRoles($role);

        // password - and encoding
        $encodedPassword = $this->passwordEncoder->encodePassword($user, $plainPassword);
        $user->setPassword($encodedPassword);
        return $user;
    }
}