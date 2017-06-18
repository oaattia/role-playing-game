<?php

namespace Oaattia\RoleBasedGameBundle\Requests;

use Oaattia\RoleBasedGameBundle\Entity\EntityInterface;
use Oaattia\RoleBasedGameBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserRegistrationRequest implements RequestInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserRegistrationRequest constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @inheritdoc
     * First item in array is email
     * Second item in array is password
     */
    public function handle(...$data) : EntityInterface
    {
        $user = new User();

        $user =  $user->setPlainPassword($data[1]);

        $user->setEmail($data[0])
             ->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));

        return $user;
    }


}