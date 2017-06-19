<?php

namespace Oaattia\RoleBasedGameBundle\Tests\Functional;

class AuthenticationControllerTest extends FunctionalTest
{
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

    public function test_if_we_can_login_and_get_token()
    {
        $this->client->request(
            'POST',
            '/api/user/register',
            ['email' => 'foo@foo.net', 'password' => 'someRandomPassword']
        );


        $this->client->request(
            'POST',
            '/api/user/login',
            ['email' => 'foo@foo.net', 'password' => 'someRandomPassword']
        );
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function test_if_login_parameters_is_valid()
    {

        $this->client->request(
            'POST',
            '/api/user/register',
            ['email' => 'foo@foo.net', 'password' => 'someRandomPassword']
        );


        $this->client->request(
            'POST',
            '/api/user/login',
            ['email' => 'notEmail', 'password' => '']
        );

        $this->assertRegexp('/Validation Error!/', $this->client->getResponse()->getContent());
        $this->assertEquals(422, $this->client->getResponse()->getStatusCode());

        $this->client->request(
            'POST',
            '/api/user/login',
            ['email' => 'test@test.com', 'password' => '']
        );

        $this->assertRegexp('/User not found/', $this->client->getResponse()->getContent());
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }
}
