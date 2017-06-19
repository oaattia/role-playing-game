<?php

namespace Oaattia\RoleBasedGameBundle\Tests\Functional;

class CharacterControllerTest extends FunctionalTest
{
    public function test_if_we_can_create_character_for_specific_user()
    {
        $client = $this->getAuthenticatedClient('foo@bar.com', 'fooBazPassword');

        $client->request(
            'POST',
            '/api/characters',
            ['title' => 'super man', 'attack' => 10, 'defense' => 20]
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertRegexp('/Character for the user created/', $client->getResponse()->getContent());
    }

    public function test_if_we_can_create_more_than_one_character_for_specific_user()
    {
        $client = $this->getAuthenticatedClient('foo@bar.com', 'fooBazPassword');

        $client->request(
            'POST',
            '/api/characters',
            ['title' => 'super man', 'attack' => 10, 'defense' => 20]
        );

        $client->request(
            'POST',
            '/api/characters',
            ['title' => 'wonder woman', 'attack' => 10, 'defense' => 20]
        );

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
        $this->assertRegexp('/You already added your character, you can only have one character/', $client->getResponse()->getContent());
    }

    public function test_if_we_get_validation_error_if_parameters_missings()
    {
        $client = $this->getAuthenticatedClient('foo@bar.com', 'fooBazPassword');

        $client->request(
            'POST',
            '/api/characters',
            ['title' => 'super man', 'attack' => null, 'defense' => 20]
        );

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }
}