<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Product;

class PurchaseController extends Controller
{
    /**
     * @Route("/purchase", name="purchase")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);
        $products = $repo->findAll();

        return $this->render('purchase/purchase.html.twig',
            [
                'products' => $products,
                'pageTitle' => 'Purchase'
            ]);
    }
}
