<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\ProductOrder;
use App\Entity\ProductOrderItem;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use App\Repository\ProductOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\PurchaseController;
use App\Manager\ExcelManager;

/**
 * @Route("/customer")
 */
class CustomerController extends Controller
{
    protected $excelManager;

    public function __construct(ExcelManager $excelManager)
    {
        $this->excelManager = $excelManager;
    }

    /**
     * @Route("/", name="customer_index", methods="GET")
     */
    public function index(CustomerRepository $customerRepository): Response
    {
        return $this->render('customer/index.html.twig', ['customers' => $customerRepository->findAll(), 'pageTitle' => 'Customers']);
    }

    /**
     * @Route("/new", name="customer_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            $this->addFlash(
                'success',
                'Customer has been added.'
            );

            return $this->redirectToRoute('customer_index');
        }

        return $this->render('customer/new.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
            'pageTitle' => 'Create New Customer'
        ]);
    }

    /**
     * @Route("/{id}", name="customer_show", methods="GET")
     */
    public function show(Customer $customer): Response
    {
        return $this->render('customer/show.html.twig',
            [
                'customer' => $customer,
                'pageTitle' => 'Customer - '.$customer->getFirstName().' '.$customer->getLastName()
            ]);
    }

    /**
     * @Route("/{id}/edit", name="customer_edit", methods="GET|POST")
     */
    public function edit(Request $request, Customer $customer): Response
    {
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Your changes were saved!'
            );

            return $this->redirectToRoute('customer_edit', ['id' => $customer->getId()]);
        }

        return $this->render('customer/edit.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
            'pageTitle' => 'Edit Customer - '.$customer->getFirstName().' '.$customer->getLastName()
        ]);
    }

    /**
     * @Route("/{id}", name="customer_delete", methods="DELETE")
     */
    public function delete(Request $request, Customer $customer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$customer->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($customer);
            $em->flush();
        }

        return $this->redirectToRoute('customer_index');
    }

    /**
     * @Route("/search/", name="ajax_search", methods="GET")
     */
    public function searchCustomer(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('query');
        $customers =  $em->getRepository(Customer::class)->findCustomerByString($requestString);

        if(!$customers) {
            $result['customers']['error'] = "No customer found, click to create new...";
        } else {
            $result['customers'] = $this->getCustomerFullName($customers);
        }
        return new Response(json_encode($result));
    }

    /*
     * Function to render customer name
     */
    public function getCustomerFullName($customers){
        $names = array();
        foreach ($customers as $customer){
            $names[$customer->getId()]['value'] = $customer->getId();
            $names[$customer->getId()]['label'] = $customer->getFirstName()." ".$customer->getLastName();
        }
        return $names;
    }

    /**
     * @Route("/{id}/purchase", name="customer_purchase", methods="GET|POST")
     */
    public function customerPurchaseAction(Customer $customer): Response
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);
        $products = $repo->findAll();

        return $this->render('purchase/purchase.html.twig', ['customer' => $customer, 'products' => $products]);
//        return $this->redirectToRoute('purchase');
    }

    /**
     * @Route("/{id}/order", name="customer_order_log", methods="GET")
     */
    public function customerOrderLogAction(Customer $customer): Response
    {
        $repo = $this->getDoctrine()->getRepository(ProductOrder::class);
        $productOrders = $repo->findCustomerOrders($customer);

        return $this->render('customer/order-log.html.twig',
            [
                'customer' => $customer,
                'orders' => $productOrders,
                'pageTitle' => 'Order Log - '.$customer->getFirstName().' '.$customer->getLastName()#
            ]
        );
    }

    /**
     * @Route("/invoice/{id}", name="generate_customer_invoice", methods="GET")
     */
    public function customerInvoiceAction(ProductOrder $productOrder): Response
    {
        $repo = $this->getDoctrine()->getRepository(ProductOrder::class);
        $productOrder = $repo->find($productOrder->getId());

        return $this->excelManager->generateInvoice($productOrder, $this->get('phpexcel'));
    }
}
