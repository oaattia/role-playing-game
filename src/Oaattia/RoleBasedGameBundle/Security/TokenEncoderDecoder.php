<?php


namespace Oaattia\RoleBasedGameBundle\Security;


use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Oaattia\RoleBasedGameBundle\Entity\User;

class TokenEncoderDecoder
{

    const EXPIRATION_TIME = 21600;


    /**
     * @var JWTEncoderInterface
     */
    private $encoder;

    /**
     * TokenEncoder constructor.
     * @param JWTEncoderInterface $encoder
     */
    public function __construct(JWTEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Encode the data for the user
     *
     * @param User $user
     * @return string $token
     */
    public function encode(User $user) : string
    {
        $token = $this->encoder->encode(
            [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'email' => $user->getUsername(),
                'password' => $user->getPassword(),
                'role' => $user->getRoles(),
                'exp' => time() + self::EXPIRATION_TIME,        // 6 hours
            ]
        );

        return $token;
    }

    /**
     * Return encoded data decoded
     *
     * @param string $token
     * @return array $data
     */
    public function decode(string $token) : array
    {
        $data = $this->encoder->decode($token);

        return $data;
    }


    private function extractToken($header) : string
    {
        // to implement
    }

}