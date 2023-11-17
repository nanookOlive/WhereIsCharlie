<?php

namespace App\DataFixtures;

use App\Entity\Users;
use App\Service\CoordService;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    private $coordService;

    public function __construct(CoordService $coordService){

        $this->coordService=$coordService;
    }
    public function load(ObjectManager $manager ): void
    {
        //création d'un ensemble de user 
        //on va set leur longitude et leur latitute 
        //à partir d'une adresse envoyé en json lors de l'inscritpion d'un user
        //on pourrait imaginer un event listener ou entity listener pour set lon et lat 
        //un tableau d'adresse 

        // TODO feed $arrayAddress
        $arrayAddress=[
            '1 rue Ameline Nantes',
            '224 boulevard Schuman Nantes',
            '72 boulevard des Anglais Nantes',
            '26 Boulevard de la Chauviniere Nantes',
            '12 rue Alexandre Fourny Nantes',
            '1O rue Amiral Courbet Nantes'
        ];

       

        // on fait appel au service qui va extrapoler les coordonnées gps
        // à partir de l'adresse 

        //on boucle 

        for($a=0;$a<count($arrayAddress);$a++){

            $user=new Users();
            $user->setName('User '.$a);
            $user->setCity('Nantes');
            $user->setAddrees($arrayAddress[$a]);

            
                $user->setLatitude($this->coordService->getCoordo($arrayAddress[$a],'lat'));
                $user->setLongitude($this->coordService->getCoordo($arrayAddress[$a]));
                $manager->persist($user);
            
        }

        $manager->flush();
    }
}
