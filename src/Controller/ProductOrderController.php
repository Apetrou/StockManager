<?php
/**
 * Created by PhpStorm.
 * User: apetrou
 * Date: 15/08/2018
 * Time: 20:40
 */

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\ProductOrder;
use App\Entity\ProductOrderItem;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Order;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductOrderController extends Controller
{
    /**
     * @Route("/order/create", name="order_create")
     */
    public function createProductOrder(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        $customerId = $request->request->get('customerId', null);
        $productOrderItems = $request->request->get('orderItems');

        try {
            $customer =  $em->getRepository(Customer::class)->find($customerId);
            $productOrderItems = json_decode($productOrderItems, true);

            $productOrder = new ProductOrder($customer);

            foreach($productOrderItems as $productOrderItem) {
                $product = $em->getRepository(Product::class)->find($productOrderItem['productId']);
                $orderItem = new ProductOrderItem($product, $productOrderItem['productQuantity'], $productOrderItem['cost']);
                $productOrder->addProductOrderItem($orderItem);
            }

            $em->persist($productOrder);
            $em->flush();

            $em->getConnection()->commit();



        } catch (Exception $e) {
            $em->getConnection()->rollBack();

            $this->addFlash(
                'error',
                'Order failed.'
            );

            return $e->getMessage();
        }

//        try {
//            // DEDUCT STOCK REGISTERED AS SERVICE
//        } catch(Exception $e) {
//            $em->getConnection()->rollBack();
//            return $e->getMessage();
//        }

        return $this->redirectToRoute('home');
//        return true;
    }

    /**
     * @Route("/order/remove/{orderId}", name="order_remove")
     */
    public function removeProductOrder()
    {

    }

    /**
     * @Route("/order/update/{orderId}", name="order_update")
     */
    public function updateProductOrder()
    {

    }

    public function generateInvoice()
    {
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject('file.xls');

    }
}