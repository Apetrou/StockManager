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
use App\Manager\StockManager;
use App\Manager\ExcelManager;
use http\Exception;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Order;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;

class ProductOrderController extends Controller
{

    protected $stockManager;

    protected $excelManager;

    protected $logger;

    public function __construct(StockManager $stockManager, ExcelManager $excelManager, LoggerInterface $logger)
    {
        $this->stockManager = $stockManager;
        $this->excelManager = $excelManager;
        $this->logger = $logger;
    }

    /**
     * @Route("/order/create", name="order_create")
     */
    public function createProductOrder(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        $requestData = json_decode($request->getContent(),true);

        $customerId = $requestData['customerId'];
        $productOrderItems = $requestData['orderItems'];

        try {
            if(!is_null($customerId)) {
                $customer =  $em->getRepository(Customer::class)->find($customerId);
            } else {
                $customer = null;
            }

            $productOrder = new ProductOrder($customer);

            foreach($productOrderItems as $productOrderItem) {
                $product = $em->getRepository(Product::class)->find($productOrderItem['productId']);
                $orderItem = new ProductOrderItem($product, $productOrderItem['productQuantity'], $productOrderItem['cost']);
                $productOrder->addProductOrderItem($orderItem);
                $this->stockManager->deductStock($product, $productOrderItem['productQuantity']);
            }

            $em->persist($productOrder);
            $em->flush();

            $em->getConnection()->commit();

            if(!is_null($customer)) {
                $this->addFlash(
                    'success',
                    'Your purchase for '.$customer->getFirstName().' has been generated.'
                );
            } else {
                $this->addFlash(
                    'success',
                    'Your purchase has been generated.'
                );
            }

        } catch (Exception $e) {
            $em->getConnection()->rollBack();

            $this->addFlash(
                'error',
                'Order failed.'
            );

            $this->logger->error($e->getMessage());

            return new JsonResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // RETURN THE INVOICE
        return $this->excelManager->generateInvoice($productOrder, $this->get('phpexcel'));
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

    /**
     * @Route("/purchase/order/log", name="order_log", methods="GET")
     */
    public function orderLogAction(): Response
    {
        $repo = $this->getDoctrine()->getRepository(ProductOrder::class);
        $productOrders = $repo->findAll();

        return $this->render('purchase/order-log.html.twig', ['orders' => $productOrders]);
    }

    /**
     * @Route("/invoice/{id}", name="generate_invoice")
     */
    public function invoiceAction(ProductOrder $productOrder): Response
    {
        $repo = $this->getDoctrine()->getRepository(ProductOrder::class);
        $productOrder = $repo->find($productOrder->getId());

        return $this->excelManager->generateInvoice($productOrder, $this->get('phpexcel'));
    }
}