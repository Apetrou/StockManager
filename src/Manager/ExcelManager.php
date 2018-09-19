<?php
/**
 * Created by PhpStorm.
 * User: apetrou
 * Date: 25/08/2018
 * Time: 12:15
 */

namespace App\Manager;

use App\Kernel;
use Liuggio\ExcelBundle\Factory;
use App\Entity\ProductOrder;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
//use App\Entity\ProductOrder;

class ExcelManager
{
    private $kernelRootDirectory;

//    private $excelS;
    private  $vat;

    public function __construct($kernelRootDirectory)
    {
        $this->kernelRootDirectory = $kernelRootDirectory;
//        $this->excelS = $excelService;
        $this->vat = 0.19;
    }

    public function generateInvoice(ProductOrder $productOrder, $excelService)
    {
        $phpExcelObject = $excelService->createPHPExcelObject($this->kernelRootDirectory.'/assets/excel/receipt.xlsx');
        $phpExcelObject->setActiveSheetIndex(0)
            ->setCellValue('F4', $productOrder->getOrderDate()->format('Y-m-d'))
            ->setCellValue('F5', $productOrder->getId());
        if(!is_null($productOrder->getCustomer())) {
            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('C8', $productOrder->getCustomer()->getFirstName()." ".$productOrder->getCustomer()->getLastName())
                ->setCellValue('C9', $productOrder->getCustomer()->getTelephoneNumber());
        } else {
            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('C8', "N/A")
                ->setCellValue('C9', "N/A");
        }

        $counter = 14;

        $totalCost = 0;

        foreach($productOrder->getProductOrderItems() as $productOrderItem) {
            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('B'.$counter, $productOrderItem->getProduct()->getName())
                ->setCellValue('C'.$counter, $productOrderItem->getProductQuantity())
                ->setCellValue('D'.$counter, $productOrderItem->getCost())
                // make vat a global var
                ->setCellValue('E'.$counter, ( (float) $productOrderItem->getCost()) * 0.19)
                ->setCellValue('F'.$counter, $productOrderItem->getCost() + ((float) $productOrderItem->getCost() * $this->vat));

            $totalCost += (float) $productOrderItem->getCost();


            $counter++;
        }

        $phpExcelObject->setActiveSheetIndex(0)
            ->setCellValue('F33', $totalCost)
            ->setCellValue('F34', $totalCost * $this->vat)
            ->setCellValue('F35', $totalCost + ($totalCost * $this->vat));

        $writer = $excelService->createWriter($phpExcelObject, 'Excel2007');

        $response = $excelService->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'receipt_order_'.$productOrder->getId().'.xlsx'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Invoice-Number', $productOrder->getId());
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }
}