<?php
/**
 * Created by PhpStorm.
 * User: oaattia
 * Date: 6/15/17
 * Time: 2:20 AM
 */

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