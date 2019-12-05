<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlList
     *
     */
    public function testIndexAction($url)
    {
        $client = static::createClient();

        // Enable profiler needs to be called before making a request
        $client->enableProfiler();

        //follow redirect automactially if the response is of a redirect
        $client->followRedirects();

        $client->request('GET', $url);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // get profiler data
        $profile = $client->getProfile();
        $this->assertEquals(0, $profile->getCollector('db')->getQueryCount());
        $this->assertLessThan(5000, $profile->getCollector('time')->getDuration());

    }

    public function urlList()
    {
        return [
            ['/'],
        ];
    }
}
