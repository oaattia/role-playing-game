<?php


namespace Oaattia\RoleBasedGameBundle\DomainManager;


use Doctrine\ORM\EntityManagerInterface;
use Oaattia\RoleBasedGameBundle\Entity\Character;
use Oaattia\RoleBasedGameBundle\Entity\User;

class UserManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var User
     */
    private $user;

    /**
     * UserManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        User $user
    ) {
        $this->entityManager = $entityManager;
        $this->user = $user;
    }

    /**
     * Create new user with email and password
     *
     * @param User $user
     */
    public function createUser(User $user)
    {
        $this->entityManager->persist($user);

        $this->entityManager->flush();
    }

    /**
     * Perform the attack to user
     * and change the user status to `attacked`
     *
     * @param User $user ( user to attack )
     * @param User $currentUser ( the current user )
     */
    public function performAttackTo(User $user, User $currentUser)
    {
        // let reset the status and the turn of both want to attack each others again
        if (
            $user->getCharacter()->getStatus() == 'attacked' &&
            $user->getCharacter()->getNextTurn() == true &&
            $currentUser->getCharacter()->getStatus() == 'attacked' &&
            $currentUser->getCharacter()->getNextTurn() == true
        ) {
            $user->getCharacter()->setNextTurn(false);
            $currentUser->getCharacter()->setNextTurn(false);
        }
        
        $user->getCharacter()->attack();

        $attack = $user->getCharacter()->getAttack();
        $status = $user->getCharacter()->getStatus();
        $nextTurn = $user->getCharacter()->getNextTurn();

        $user->getcharacter()->setAttack($attack);
        $user->getcharacter()->setStatus($status);
        $user->getcharacter()->setNextTurn($nextTurn);

        $this->entityManager->persist($user->getCharacter());
        $this->entityManager->flush();

    }
}