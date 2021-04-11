<?php

namespace App\Controller;

use App\Entity\File;
use App\Form\FileFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadController extends AbstractController
{
    /**
     * @Route("/upload", name="upload")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $fileEntity = new File();

        $form = $this->createForm(FileFormType::class, $fileEntity);

        $form->handleRequest($request);

            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $file_upload = $request->files->get('name');

            $file = file($file_upload->getPathName());

            $array_php = array(
                "name" => $file_upload->getClientOriginalName()
            );
            $array_data = array();

            foreach ($file as $data){
                $explode = explode(',', $data);
                $array_data[] = array(
                    "date" => [
                        "id" => $explode[0],
                        "name" => $explode[1],
                        "value" => $explode[2]
                    ]
                );
                //array_push($array_php, $array_data);

            }

            dump($array_php);die();

            //$array_json = $this->get('jms_serializer')->deserialize($array_php, 'array', 'json');


        return $this->render('upload/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
