<?php

namespace App\Service;
use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class UsersProx{


    private $client;
    private $urlApi="https://wxs.ign.fr/calcul/geoportail/itineraire/rest/1.0.0/route?resource=bdtopo-osrm";
    private $usersRepository;
    public function __construct(HttpClientInterface $client,UsersRepository $usersRepository){

        $this->client=$client;
        $this->usersRepository=$usersRepository;
    }
//méthode qui va renvoyer un tableau de user selon un critère
//ici selon la distance 
    public function getUsersProx(Users $user, int $rayon,){

        //un user de la base à comparer avec le user en arg
        //faire une boucle en récuprant tout les users d'une ville 

        $usersByCity=$this->usersRepository->findBy(['city'=>"Nantes"]);
        $reponse=[];

        foreach($usersByCity as $userToCompare){

            $content=$this->client->request(
                        'GET',
                        $this->urlApi,
                        [
                            "query"=>[
                                "start"=>$user->getLongitude().','.$user->getLatitude(),
                                "end"=>$userToCompare->getLongitude().','.$userToCompare->getLatitude()
                            ]
                        ]
                    );
            if($content->toArray()['distance']/1000<$rayon){

                $reponse[$userToCompare->getId()]=$userToCompare;
            }

       

        }
        //le resultat de la requete
        
        dd($reponse);
    }



}