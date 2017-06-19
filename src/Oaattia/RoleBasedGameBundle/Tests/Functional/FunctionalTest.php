<?php


namespace Oaattia\RoleBasedGameBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


abstract class FunctionalTest extends WebTestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function getAuthenticatedClient($email, $password)
    {
//        $client = static::createClient();
        $this->client->request(
            'POST',
            '/api/user/register',
            ['email' => $email, 'password' => $password]
        );

        $data = json_decode($this->client->getResponse()->getContent(), true);

//        $client = static::createClient();
        $this->client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['data']['token']));

        return $this->client;
    }

}