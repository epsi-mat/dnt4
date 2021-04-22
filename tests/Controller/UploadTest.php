<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadTest extends WebTestCase
{
    public function testUpload() : void
    {
        $client = static::createClient();

        $file_upload = new UploadedFile(
            'public/uploads/files/myFile.csv',
            'myFile.csv',
            'text/csv'
        );

        $client->request('POST', '/api/files',[],['file' => $file_upload]);

        $this->assertResponseStatusCodeSame(201);
    }
}