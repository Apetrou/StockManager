<?php
/**
 * Created by PhpStorm.
 * User: apetrou
 * Date: 22/08/2018
 * Time: 22:43
 */

namespace App\Manager;


use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class StockManager
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function deductStock(Product $product, $productQuantity)
    {
        try {
            $product->setStock($product->getStock() - (int) $productQuantity);
            $this->entityManager->persist($product);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return $e;
        }
    }
}