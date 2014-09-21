<?php

namespace Levi9\HighLoadBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/show/john_smitt');

        $this->assertTrue($crawler->filter('html:contains("Lorem ipsum dolor sit amet")')->count() > 0);
    }
}
