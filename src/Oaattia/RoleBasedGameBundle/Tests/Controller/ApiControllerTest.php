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

    public function test_if_passing_right_date_username_and_password_return_OK()
    {
        $this->client->request(
            'POST',
            '/api/user/register',
            ['email' => 'foo@foo.net', 'password' => 'someRandomPassword']
        );

        $this->assertSame('{"code":201,"links":{"current":"","next":"","prev":"127.0.0.1"},"message":"Successfully Created"}', $this->client->getResponse()->getContent());
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
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
            ['email' => 'foo@foo.net', 'password' => 'someRandomPassword']
        );



    }
}
