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
        
        /**
         * tableau d'adresses vraient ou faussent selon rayon=2km
         * table
         */

        $arrayAddress=[
            '1 rue Ameline Nantes',//Origine
            '23 Rue Emile Souvestre Nantes', //TRUE ouest
            '19 Rue Louis Primault Nantes', //TRUE est
            '111 Boulevard Michelet Nantes',//TRUE nord
            '1 Rue de Bel air Nantes',//TRUE sud
            '24 Rue Recteur Schmitt Nantes',//FALSE nord
            '16 rue de Rieux Nantes',//FALSE sud
            '134 Boulevard des Anglais Nantes',//FALSE ouest
            '66 Bd des Poilus Nantes',//FALSE est
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
