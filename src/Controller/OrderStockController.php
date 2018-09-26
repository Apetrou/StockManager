<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class OrderStockController extends Controller
{
    /**
     * @Route("/order/stock", name="order_stock")
     */
    public function index()
    {
        return $this->render('order_stock/index.html.twig', [
            'controller_name' => 'OrderStockController',
            'pageTitle' => 'Order Stock'
        ]);
    }
}
