<?php 

namespace App\Service;

use App\Entity\Users;
use App\Repository\UsersRepository;


class UserProxByCal{


    /// le service travaillera avec 2 users
    // à terme un des users sera entityManager->get_current_user

    //deux formules de calcul
    /**
     * 1 degre lat = 111 km 
     * le calcul de la limite lat sera lat de user + 1/111*rayon de recherche
     * l'equivalence en km d'un degré de longitude dépends de la latitude 
     * la limite en long sera longitude de user + rayon/(cosinus de lat de user)*111
     * 
     * les limtes d'une zone de recherche sont x2+y2=r2
     * 
     * 
     */     

     private $longitudeOrigine;
     private $latitudeOrigine;


     public function __construct(UsersRepository $userRepo){

        $innerUser=$userRepo->find(69);
        $this->latitudeOrigine=$innerUser->getLatitude();
        $this->longitudeOrigine=$innerUser->getLongitude();

     }


     public function valideUser(Users $user,int $rayon){


        $bornes=$this->bornes($rayon);
        
        //if($user->getLatitude()> $bornes['maxNord'] && $user->getLatitude() < $bornes['maxSud']){
            //si la latitude est dans la limite on teste alors la longitude
            /**
             * la prrmière solution serait de faire de la zone de recherche un carré
             * if($user->getLongitude()>$bornes['maxOuest'] && $user->getLongitude()<$bornes['maxEst']){
             * 
             *  return TRUE;
             * }
             * 
             * else{
             *  return FALSE;
             * }
             */
            //la formule
                
                $y=$user->getLatitude()-$this->latitudeOrigine;
                $x=$user->getLongitude()-$this->longitudeOrigine;
                $r=sqrt(pow($x,2)+pow($y,2));

                dd($r*111);
            


                dd($message);
                            //la deuxième serait de faire un cercle user lat et user long sont l'origine
            

                
        //}

        return false;
     }

     private  function bornes(int $rayon):array
     {
        
        $incrementLat=(1/111)*$rayon;
        $incrementLong=$rayon/(cos($this->latitudeOrigine)*111);
        $bornes=[
            "maxNord"=>$this->latitudeOrigine-$incrementLat,
            "maxSud"=>$this->latitudeOrigine+$incrementLat,
            "maxEst"=>$this->longitudeOrigine-$incrementLong,
            "maxOuest"=>$this->longitudeOrigine+$incrementLong,
            "incrementLat"=>$incrementLat,
            "incrementLong"=>$incrementLong
            ];

        return $bornes;
     }

     private function degLatEnKm(float $lat){

        return $lat*(1/111);
     }

     private function latEnDeg(float $lat){

        return $lat/(1/111);
     }
     private function degLongEnKm(float $lat, float $long){


        return $long*(cos($lat)*111);
     }
     private function longEnDeg(float $long){}


}