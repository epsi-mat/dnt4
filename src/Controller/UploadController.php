<?php

namespace App\Controller;

use App\Entity\Data;
use App\Form\UploadType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    /**
     * @Route("/upload", name="upload")
     */
    public function index(): Response
    {
        $upload = new Data();

        $form = $this->createForm(UploadType::class, $upload);

        return $this->render('upload/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
