<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UploadTest extends WebTestCase
{
    public function testGetFile() : void
    {
        $client = static::createClient();
        $client->request('GET', '/api/files');
        $this->assertResponseStatusCodeSame(200);
    }
}