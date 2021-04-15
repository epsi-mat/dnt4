<?php

namespace App\Controller;

use App\Entity\Data;
use App\Entity\File;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{

    /**
     * @Route("/api/files", name="api_post_file", methods={"POST"})
     */
    public function createFile(Request $request, EntityManagerInterface $em){
        $file = new File();
        $content_file_implode = array();

        $json_file = $request->files->get('file');
        $content_file = file($json_file);

        for($row = 0; $row < count($content_file); $row++){
            $content_file[$row] = str_replace("\r\n", "", $content_file[$row]);
            $content_file_implode[] = explode(";", $content_file[$row]);
        }

        $file->setName($json_file->getClientOriginalName());

        foreach($content_file_implode as $item){
            $data_entity = new Data();
            $data_entity->setName($item[0]);
            $data_entity->setContent($item[1]);
            $file->addData($data_entity);
        }

        $em->persist($file);
        $em->flush();

        return $this->json($file, 201, [], ['groups' => 'post:read']);
    }

}
