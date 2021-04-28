<?php


namespace App\Tests\Entity;


use App\Entity\DataFile;
use App\Entity\File;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

class FileKernelTest extends KernelTestCase
{
    public function getEntity(): File
    {
        return (new File())
            ->setName('content')
            ->addData(new DataFile());
    }

    public function valideEntity(File $file, int $number = 0){
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($file);
        $messages = array();
        /** @var ConstraintViolation $error */
        foreach ($errors as $error){
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
        $this->assertCount($number, $errors, implode(', ', $messages));
    }

    public function testValidFileEntity(){
        $this->valideEntity($this->getEntity(), 0);
    }

    public function testInvalidBlankNameEntity(){
        $this->valideEntity($this->getEntity()->setName(''), 0); // test faux pour tester le CI => 1
    }
}