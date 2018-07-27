<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PurchaseController extends Controller
{
    /**
     * @Route("/purchase", name="purchase")
     */
    public function index()
    {
        return $this->render('purchase/index.html.twig', [
            'controller_name' => 'PurchaseController',
        ]);
    }
}
