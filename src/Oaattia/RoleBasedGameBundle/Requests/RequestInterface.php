<?php

namespace Oaattia\RoleBasedGameBundle\Requests;

use Oaattia\RoleBasedGameBundle\Entity\EntityInterface;

interface RequestInterface
{

    /**
     * Return the entity after setting values to the it.
     *
     * @param array $data
     * @return EntityInterface
     */
    public function handle(...$data) : EntityInterface;
}