<?php

namespace App\Controller;

use App\Service\UsersProx;
use App\Service\CoordService;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProxiServiceController extends AbstractController
{
    #[Route('/proxi/service', name: 'app_proxi_service')]
    public function index(UsersProx $usersProx,UsersRepository $userRepo,CoordService $coord): Response
    {


        dd($coord->getCoordo('10 rue Amiral Courbet Nantes'));
       
        $user=$userRepo->find(46);

        $usersProx->getUsersProx($user,2);
       

        
        return $this->render('show.html.twig',['address'=>$data
            
        ]);
    }
}
