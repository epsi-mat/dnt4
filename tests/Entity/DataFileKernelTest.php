<?php


namespace App\Tests\Entity;


use App\Entity\DataFile;
use App\Entity\File;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

class DataFileKernelTest extends KernelTestCase
{


    public function getEntity(): DataFile
    {
        return (new DataFile())
            ->setName('content')
            ->setContent('nouvelle ruelle');
    }

    public function valideEntity(DataFile $data, int $number = 0){
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($data);
        $messages = array();
        /** @var ConstraintViolation $error */
        foreach ($errors as $error){
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
        $this->assertCount($number, $errors, implode(', ', $messages));
    }

    public function testValidDataEntity(){
        $this->valideEntity($this->getEntity(), 0);
    }

    public function testInvalidBlankNameEntity(){
        $this->valideEntity($this->getEntity()->setName(''), 1);
    }

    public function testInvalidBlankContentEntity(){
        $this->valideEntity($this->getEntity()->setContent(''), 1);
    }

}