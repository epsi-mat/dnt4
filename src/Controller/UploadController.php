<?php

namespace App\Controller;

use App\Entity\DataFile;
use App\Entity\File;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UploadController extends AbstractController
{

    /**
     * @Route("upload", name="upload_index")
     */
    public function indexUpload(){
        return $this->render('upload/index.html.twig');
    }

    /**
     * @Route("/api/files", name="api_get_file", methods={"GET"})
     */
    public function getFile(){
        $files = $this->getDoctrine()
            ->getRepository(File::class)
            ->findAll();
        return $this->json($files, 200, [],['groups' => 'post:read']);
    }

    /**
     * @Route("/api/files", name="api_post_file", methods={"POST"})
     */
    public function createFile(Request $request, EntityManagerInterface $em, ValidatorInterface $validator, SluggerInterface $slugger){
        try {
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
                    $nb_colonnes = count($item);
                    if($nb_colonnes > 3){
                        return $this->json("Le nombre de colonnes est superieur à 3 colonnes", 400);
                    }
                    $data_entity = new DataFile(); // J'instancie à chaque itération un objet DataFile
                    $data_entity->setName($item->name); // J'ajoute la donnée name contenu dans l'emplacement du tableau name dans l'attribut de l'objet DataFile
                    $data_entity->setContent($item->value); // J'ajoute la donnée  value contenu dans l'emplacement du tableau name dans l'attribut de l'objet DataFile
                    $file->addData($data_entity); // J'ajoute ensuite l'objet DataFile composée des éléments suivant dans l'objet File relié par la relation OneToMany à l'objet DataFile
                }
                // Je varifie que l'ensemble des données de l'objet file est valide
                $error = $validator->validate($file);
                // je vérifie si il y a une error
                if(count($error) > 0){
                    return $this->json($error, 400); //Je met fin à la requête et je renvoie l'erreur
                }
                // Je persist l'objet File est ces données
                $em->persist($file);
                // J'envoi l'objet File
                $em->flush();
            }elseif($file_info["extension"] === "csv"){
                // Je récupère le contenu du fichier csv
                $content_file = file($json_file);
                // Je parcours chaque ligne du tableau
                for($row = 0; $row < count($content_file); $row++){
                    $content_file[$row] = str_replace("\r\n", "", $content_file[$row]); // Je m'assure qu'il n'y est pas d'élément autre que des lettres et chiffres
                    $content_file_implode[] = explode(";", $content_file[$row]); // Je sépare en deux partie distinct chaque ligne ( exemple : "RT;DH" -> "RT" "DH" )
                }

                $nb_colonnes = count($content_file_implode[0]);

                if($nb_colonnes > 3){
                    return $this->json("Le nombre de colonnes est superieur à 3 colonnes", 400);
                }

                $file->setName($file_info["filename"]);

                foreach($content_file_implode as $item){
                    $data_entity = new DataFile();
                    $data_entity->setName($item[1]);
                    $data_entity->setContent($item[2]);
                    $file->addData($data_entity);
                }

                $error = $validator->validate($file);

                if(count($error) > 0){
                    return $this->json($error, 400);
                }

                $em->persist($file);
                $em->flush();
            }else{
                return $this->json([
                    'status' => 400,
                    'message' => "Le fichier n'a pas la bonne extension"
                ], 400);
            }

            $safeFilename = $slugger->slug($file_info["filename"]);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$file_info["extension"];
            $json_file->move($this->getParameter('files_directory'), $newFilename);

            // Je retourne l'objet file en format json à la route de l'API stipulé en paramétre de ma fonction (json s'occupe de tout)
            return $this->json($file, 201, [], ['groups' => 'post:read']);

        }catch (NotEncodableValueException $e){
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

}
