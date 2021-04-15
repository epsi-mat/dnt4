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
        // Je récupère le fichier uploade
        $json_file = $request->files->get('file');
        // Je récupère l'extension du fichier
        $file_info = pathinfo($json_file->getClientOriginalName());
        // Je vérifie si l'extension est de type xml ou csv
        if($file_info["extension"] === "xml"){
            // Je récupère le contenu du fichier xml
            $content_file = simplexml_load_file($json_file->getPathName(), "SimpleXMLElement");
            // Ajout du nom du fichier dans l'objet File
            $file->setName($file_info["filename"]);
            // Je parcours le tableau de donnée du fichier xml
            foreach($content_file as $item){
                $data_entity = new Data(); // J'instancie à chaque itération un objet Data
                $data_entity->setName($item->name); // J'ajoute la donnée name contenu dans l'emplacement du tableau name dans l'attribut de l'objet Data
                $data_entity->setContent($item->value); // J'ajoute la donnée  value contenu dans l'emplacement du tableau name dans l'attribut de l'objet Data
                $file->addData($data_entity); // J'ajoute ensuite l'objet Data composée des éléments suivant dans l'objet File relié par la relation OneToMany à l'objet Data
            }
            // Je persist l'objet File est ces données
            $em->persist($file);
            // J'envoi l'objet File
            $em->flush();
        }else{
            // Je récupère le contenu du fichier csv
            $content_file = file($json_file);
            // Je parcours chaque ligne du tableau
            for($row = 0; $row < count($content_file); $row++){
                $content_file[$row] = str_replace("\r\n", "", $content_file[$row]); // Je m'assure qu'il n'y est pas d'élément autre que des lettres et chiffres
                $content_file_implode[] = explode(";", $content_file[$row]); // Je sépare en deux partie distinct chaque ligne ( exemple : "RT;DH" -> "RT" "DH" )
            }

            $file->setName($file_info["filename"]);

            foreach($content_file_implode as $item){
                $data_entity = new Data();
                $data_entity->setName($item[0]);
                $data_entity->setContent($item[1]);
                $file->addData($data_entity);
            }

            $em->persist($file);
            $em->flush();
        }
        // Je retourne l'objet file en format json à la route de l'API stipulé en paramétre de ma fonction (json s'occupe de tout)
        return $this->json($file, 201, [], ['groups' => 'post:read']);
    }

}
