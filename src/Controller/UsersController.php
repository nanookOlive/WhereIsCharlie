<?php

namespace App\Controller;

use TypeError;
use App\Entity\Users;

use App\Service\CoordService;

use App\Service\UserProxByCal;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class UsersController extends AbstractController
{
    
    #[Route('users/create', name:'app_users_create')]
    
    public function createUser(Request $request,EntityManagerInterface $manager,SerializerInterface $serializer,ValidatorInterface $validator):JsonResponse
    {

        //on récupère la cobntenu de la requête 
        $content=$request->getContent();

        //on teste le json 
        try{        
            
            $user=$serializer->deserialize($content,Users::class,'json');
            
        }
        catch(NotEncodableValueException $err){

            dd($err->getMessage());
        } 

        //on persist pour faire appel au listener 
        $manager->persist($user);
       

        //on teste la validité des champs du user 

        if(count($errors=$validator->validate($user))>0){

            $message='';
            //on personnalise message d'erreur 
            //on veut pouvoir signaler que c'est l'adresse qui n'est pas valide
            //elle est peut être nulle car non trouvé par l'api 
            foreach($errors as $error ){
                
                if($error->getPropertyPath()==="longitude"){

                    $message="Adresse non trouvée par l\'api ";
                }
            }
            return $this->json($message);
        }

        //success 
        $manager->flush();
        return $this->json('Enregistrement du user ok ',Response::HTTP_OK);
    }
       
#[Route('/test/lat/{id}','app_test')]
public function lat(Users $user,UserProxByCal $cal):JsonResponse{


    

        $response[$user->getAddrees()]=$cal->valideUser($user,2);
    


    return $this->json($response);

}

    
}
