<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadTest extends WebTestCase
{
    public function testGetFile() : void
    {
        $client = static::createClient();
        $client->request('GET', '/api/files');
        $this->assertResponseIsSuccessful();
    }

    /*public function testPostFile() : void
    {
        $client = static::createClient();

        $file_upload = new UploadedFile(
            __DIR__.'/../uploads/files/myFile.csv',
            'myFile.csv'
        );

        $client->request('POST', '/api/files',[],[
            'file' => $file_upload
        ]);

        $this->assertResponseIsSuccessful();
    }*/
}