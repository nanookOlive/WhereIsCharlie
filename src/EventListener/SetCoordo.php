<?php

namespace App\EventListener;
use ErrorException;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SetCoordo extends AbstractController{

    private $client;
    private $urlApi='https://geocode.maps.co/search?';

    public function __construct(HttpClientInterface $client){

        $this->client=$client;
    }

    public function getCoordo(Users $user){

        //les champs que l'on veut pouvoir retourner
        
        $response=$this->client->request(
            'GET',
            $this->urlApi,
            [
                'query'=>[
                'q'=>$user->getAddrees()
                ]
            ]
        );

        $content=$response->toArray();

       
        if(!empty(($content)[0]['lon'])){
            $user->setLongitude($content[0]['lon']);
            $user->setLatitude($content[0]["lat"]);
        }
            
        

        
                

    }
}