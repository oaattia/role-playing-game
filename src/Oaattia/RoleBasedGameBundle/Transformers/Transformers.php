<?php


namespace Oaattia\RoleBasedGameBundle\Transformers;


use Oaattia\RoleBasedGameBundle\Entity\EntityInterface;

abstract class Transformers
{

    /**
     * The main function to handle the transformation for the passed array
     *
     * @param array $elements
     * @return array
     */
    public function transform(array $elements) : array
    {
        $data = [];

        foreach ($elements as $item) {
            $data[] = $this->transforming($item);
        }

        return $data;
    }

    /**
     * We get the Entity and filter the returning array
     *
     * @param EntityInterface $item
     * @return array
     */
    abstract public function transforming(EntityInterface $item) : array;
}