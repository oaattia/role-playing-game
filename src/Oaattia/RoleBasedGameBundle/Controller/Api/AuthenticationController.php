<?php

namespace Oaattia\RoleBasedGameBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations\RouteResource;
use Oaattia\RoleBasedGameBundle\Controller\ApiController;
use Oaattia\RoleBasedGameBundle\Entity\User;
use Oaattia\RoleBasedGameBundle\Requests\RegistrationRequest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @RouteResource(resource="User", pluralize=false)
 *
 * Class AuthenticationController
 * @package Oaattia\RoleBasedGameBundle\Controller
 */
class AuthenticationController extends ApiController
{

    /**
     * Register a new user
     *
     * @param Request $request
     * @return json response
     */
    public function postRegisterAction(Request $request)
    {
        $user = $this->get('oaattia.role_based_game.registration_request')->handle(
            $request->get('email'),
            $request->get('password')
        );

        $violations = $this->get('oaattia_role_based_game.validator.validation')->validate($user, ['registeration']);

        if (!empty($violations)) {
            return $this->respondUnprocessedEntityError($violations);
        }

        $this->get('oaattia.role_based_game.user_manager')->createUser($user);

        $token = $this->get('oaattia_role_based_game.security.token_encoder_decoder')->encode($user);

        return $this->respondCreated(['token' => $token], "User created and authenticated");
    }


    /**
     * Login user and generate JWT token
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */
    public function postLoginAction(Request $request)
    {
        $user = $this->get('oaattia.role_based_game.registration_request')->handle(
            $request->get('email'),
            $request->get('password')
        );

        $violations = $this->get('oaattia_role_based_game.validator.validation')->validate($user);

        if (!empty($violations)) {
            return $this->respondUnprocessedEntityError($violations);
        }

        $foundUser = $this->getDoctrine()->getRepository(User::class)->findOneBy(
            [
                'email' => $user->getEmail(),
            ]
        );

        if (!$foundUser) {
            return $this->respondNotFound("User not found");
        }

        $isValidPassword = $this->get('security.password_encoder')->isPasswordValid(
            $foundUser,
            $request->get('password')
        );

        if (!$isValidPassword || is_null($foundUser)) {
            return $this->respondInternalError(
                "Credentials not matching our records, please make sure you are using the right email and password"
            );
        }

        $token = $this->get('oaattia_role_based_game.security.token_encoder_decoder')->encode($user);

        return $this->respondOK(
            [
                'token' => $token,
            ]
        );
    }

}
