<?php

namespace App\Controller;

use App\Entity\PayExpresse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PayexpresseController extends AbstractController
{
    /**
     * @Route("/payexpresse", name="payexpresse")
     */
    public function index()
    {
        



$id = !empty($_POST['item_id']) ? intval($_POST['item_id']) : null;//id 1
$items = json_decode(file_get_contents('article.json'), true)['articles'];//
$key = array_search($id, array_column($items, 'id'));//bool si l id est trouvé il renvoi true
$id = !empty($_POST['item_id']) ? intval($_POST['item_id']) : null;//id 1

if($key === false || $id === null)
{
    echo json_encode([
        'success' => -1, //or false,
        'errors' => [
            'article avec cet id non trouvé'
        ]
    ], JSON_PRETTY_PRINT|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE);
}
else{

    $item = (object)$items[$key];
    //$item ={}
    //global $apiKey, $apiSecret;//dans conf.php
    $apiKey = '0a58c37e1b2bdc64462637d2dd8a1a3ca4c312884a5d89a6031d41853e1561d6';
    $apiSecret ='98dc76a3c2c4744cbca69f107ed21986641b6160ec5e562a6dfd7c5736f777bb';
    $response = (new PayExpresse($apiKey, $apiSecret))->setQuery([
        'item_name' => $item->name,
        'item_price' => $item->price,
        'command_name' => "Paiement {$item->name} Gold via PayExpresse",
    ])->setCustomeField([
        'item_id' => $id,
        'time_command' => time(),
        'ip_user' => $_SERVER['REMOTE_ADDR'],
        'lang' => $_SERVER['HTTP_ACCEPT_LANGUAGE']
    ]);
        $response->setnoCalculateFee(1);// default 0 
        $response->setCurrency($item->currency);
        $response->setRefCommand(uniqid());
        $response->setNotificationUrl([
            'success_url' => BASE_URL.'index.php?state=success&id='.$id,
            'cancel_url' =>   BASE_URL.'index.php?state=cancel&id='.$id
        ]);
        $reponse_donne = $response->send();//objet token
    echo json_encode($reponse_donne);
}





return $this->render('payexpresse/index.html.twig', [
            'controller_name' => 'PayexpresseController',
        ]);
    }
}
