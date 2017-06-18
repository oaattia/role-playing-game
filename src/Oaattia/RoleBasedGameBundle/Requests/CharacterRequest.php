<?php

namespace Oaattia\RoleBasedGameBundle\Requests;

use Oaattia\RoleBasedGameBundle\Entity\Character;
use Oaattia\RoleBasedGameBundle\Entity\EntityInterface;


class CharacterRequest implements RequestInterface
{

    /**
     * Return the entity after setting values to the it.
     *
     * @param array $data
     * @return EntityInterface
     */
    public function handle(...$data) : EntityInterface
    {
        $character = new Character();

        $character
            ->setTitle($data[0])
            ->setAttack($data[1])
            ->setDefense($data[2])
            ->setUser($data[3])
            ->setStatus($data[4]);

        return $character;
    }
}