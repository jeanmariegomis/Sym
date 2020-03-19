<?php

namespace App\Controller;

use App\Entity\Achat;
use App\Form\AchatType;
use App\Repository\PrixRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/** 
 * @Route("/api")
 */

class AchatController extends AbstractFOSRestController
{

    private $message;
    private $status;
    private $prixFixe;
    private $montant;
    public function __construct()
    {
        $this->message="message";
        $this->status="status";
        $this->prixFixe='prix';
        $this->montant= "montant";
    } 


    /**
     * @Route("/achat", methods={"POST"})
     */


    public function depot (Request $request, ValidatorInterface $validator, PrixRepository $repo, EntityManagerInterface $entityManager){
        $achat = new Achat();
        $form = $this->createForm(AchatType::class, $achat);
        $data = $request->request->all();
        
        if($prix=$repo->findOneBy([ $this->montant=>$data[$this->prixFixe]])){
            $data[$this->prixFixe]=$prix->getId();//on lui donne directement l'id
           
        }
        else{
            throw new HttpException(404,'Ce montant n\'existe pas!');
        }
        $form->submit($data);

      
           $prix=$achat->getPrix();
           $entityManager->persist($prix);
           $entityManager->persist($achat);
           $entityManager->flush();
           $afficher = [
                $this->status => 201,
                $this->message => 'Achat réussi '
           ];
           return $this->handleView($this->view($afficher,Response::HTTP_CREATED));

    }
}
