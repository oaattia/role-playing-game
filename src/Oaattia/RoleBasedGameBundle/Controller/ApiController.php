<?php

namespace Oaattia\RoleBasedGameBundle\Controller;

use FOS\RestBundle\View\View;
use Oaattia\RoleBasedGameBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiController
 * @package Oaattia\RoleBasedGameBundle\Controller
 */
class ApiController extends Controller
{
    /**
     * @var int Status Code.
     */
    private $statusCode = Response::HTTP_OK;

    /**
     * Getter method to return stored status code.
     *
     * @return mixed
     */
    public function getStatusCode() : int
    {
        return $this->statusCode;
    }

    /**
     * Setter method to set status code.
     * It is returning current object
     * for chaining purposes.
     *
     * @param mixed $statusCode
     * @return ApiController.
     */
    public function setStatusCode(int $statusCode) : ApiController
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Function to return an unauthorized response.
     *
     * @param string $message
     * @return View
     */
    public function respondUnauthorizedError(string $message = 'Unauthorized!') : View
    {
        return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)->respondWithError($message);
    }

    /**
     * Function to return forbidden error response.
     * @param string $message
     * @return View
     */
    public function respondForbiddenError(string $message = 'Forbidden!') : View
    {
        return $this->setStatusCode(Response::HTTP_FORBIDDEN)->respondWithError($message);
    }

    /**
     * Function to return a Not Found response.
     *
     * @param string $message
     * @return View
     */
    public function respondNotFound(string $message = 'Not Found') : View
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError($message);
    }

    /**
     * Function to return an internal error response.
     *
     * @param string $message
     * @return View
     */
    public function respondInternalError(string $message = 'Internal Error!') : View
    {
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }


    /**
     * Function to return an Unprocessed entity.
     *
     * @param array $violations
     * @param string $message
     * @return View
     */
    public function respondUnprocessedEntityError(array $violations, string $message = 'Validation Error!') : View
    {
        return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)->respondWithError($message, $violations);
    }


    /**
     * Function to return a service unavailable response. 503
     *
     * @param string $message
     * @return mixed
     */
    public function respondServiceUnavailable(string $message = "Service Unavailable!") : View
    {
        return $this->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE)->respondWithError($message);
    }


    /**
     * @param string $message
     * @param array $data
     *
     * @return mixed
     */
    public function respondCreated(array $data = [], string $message = "Successfully Created") : View
    {
        return $this->setStatusCode(Response::HTTP_CREATED)
            ->respond(
                $data,
                $message
            );
    }


    /**
     * @param string $message
     * @param array $data
     *
     * @return mixed
     */
    public function respondOK(array $data = [], string $message = "Successfully OK") : View
    {
        return $this->setStatusCode(Response::HTTP_OK)
            ->respond(
                $data,
                $message
            );
    }


    /**
     * Function to return a generic response.
     *
     * @param array $data
     * @param string $message
     * @return View response
     */
    private function respond(array $data, string $message) : View
    {
        $response = [
            "code" => $this->getStatusCode(),
            "message" => $message,
            "data" => $data,
        ];

        return new View($response, $this->getStatusCode()); // 200 in this case
    }

    /**
     * Function to return an error response.
     *
     * Shouldn't be called directly, but we should setStatus first for the error type
     *
     * @param string $message
     * @param array $violations
     * @return View $response
     */
    private function respondWithError(string $message, array $violations = []) : View
    {
        $format = [
            'error' => [
                'code' => $this->getStatusCode(),
                'message' => $message,
            ],
        ];

        if (!empty($violations)) {
            $format = array_merge($format['error'], ['violations' => $violations]);
        }

        return new View($format, $this->getStatusCode());
    }

    /**
     * Get the current authenticated user from the request
     *
     * @param Request $request
     * @return User
     */
    protected function getCurrentAuthenticatedUser(Request $request) : User
    {
        $credentials = $this->get('oaattia.role_based_game_authenticator.token.authenticator')->getCredentials(
            $request
        );
        $user = $this->get('lexik_jwt_authentication.encoder')->decode($credentials['token']);

        $user = $this->getDoctrine()->getRepository(User::class)->loadUserByUsername($user['username']);

        return $user;
    }


}
