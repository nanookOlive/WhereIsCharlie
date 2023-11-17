<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CoordService{

    private $client;
    private $urlApi='https://geocode.maps.co/search?';

    public function __construct(HttpClientInterface $client){

        $this->client=$client;
    }

    public function getCoordo(string $address,string $flag='long'){

        //les champs que l'on veut pouvoir retourner

        $response=$this->client->request(
            'GET',
            $this->urlApi,
            [
                'query'=>[
                'q'=>$address
                ]
            ]
        );

        $content=$response->toArray();

        if(!empty($content)){
            if($flag === 'lat'){

            return  $coordonates['latitude']=$content[0]['lat'];
        }

        return $coordonates['longitude']=$content[0]['lon'];
        }

        return null;
        

    }
}