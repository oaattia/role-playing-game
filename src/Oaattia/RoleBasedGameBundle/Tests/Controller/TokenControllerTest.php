<?php

namespace Oaattia\RoleBasedGameBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TokenControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $this->createUser('oaatta@gmail.com', 'anyFuckenPassword');
    }
}
