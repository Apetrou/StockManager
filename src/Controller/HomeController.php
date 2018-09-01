<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        if($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('product_index', array(), 301);
        } else {
            return $this->redirectToRoute('login', array(), 301);
        }
    }
}
