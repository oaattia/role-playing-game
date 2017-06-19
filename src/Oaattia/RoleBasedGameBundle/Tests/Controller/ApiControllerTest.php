<?php

namespace Oaattia\RoleBasedGameBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function test_if_passing_right_data_username_and_password_return_OK()
    {
        $this->client->request(
            'POST',
            '/api/user/register',
            ['email' => 'foo@foo.net', 'password' => 'someRandomPassword']
        );

        $this->assertRegexp('/token/', $this->client->getResponse()->getContent());
        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
    }

    public function test_if_passing_duplicate_email_it_return_validation_error()
    {

        $this->client->request(
            'POST',
            '/api/user/register',
            ['email' => 'foo@foo.net', 'password' => 'someRandomPassword']
        );

        $this->client->request(
            'POST',
            '/api/user/register',
            ['email' => 'foo@foo.net', 'password' => 'AnysomeRandomPassword']
        );

        $this->assertEquals(422, $this->client->getResponse()->getStatusCode());
    }
}
