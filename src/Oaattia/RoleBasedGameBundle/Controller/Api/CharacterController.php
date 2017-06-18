<?php

namespace Oaattia\RoleBasedGameBundle\Controller\Api;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Oaattia\RoleBasedGameBundle\Controller\ApiController;
use Oaattia\RoleBasedGameBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

/**
 * @RouteResource("Character")
 *
 * Class UserController
 * @package Oaattia\RoleBasedGameBundle\Controller
 */
class CharacterController extends ApiController
{

    /**
     * Create a new character
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View|mixed
     */
    public function postAction(Request $request)
    {
        $user = $this->getCurrentAuthenticatedUser($request);

        $character = $this->get('oaattia_role_based_game.requests.character_request')->handle(
            $request->get('title'),
            $request->get('attack'),
            $request->get('defense'),
            $user,
            "ready"
        );

        $violations = $this->get('oaattia_role_based_game.validator.validation')->validate($character);

        if (!empty($violations)) {
            return $this->respondUnprocessedEntityError($violations);
        }

        try {
            $this->get('oaattia_role_based_game.domain_manager.character_manager')->createCharacter($character);
        } catch (UniqueConstraintViolationException $exception) {
            return $this->respondInternalError("You already added your character, you can only have one character");
        }

        return $this->respondCreated([], "Character for the user created");
    }

}
