<?php
/**
 * Created by PhpStorm.
 * User: apetrou
 * Date: 20/08/2018
 * Time: 20:56
 */

namespace App\Service;

use Liuggio\ExcelBundle\Factory;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use PHPExcel;
use PHPExcel_IOFactory;

class ExcelService
{
    public function generateInvoice(array $data)
    {
        $objPHPExcel = PHPExcel_IOFactory::load($this->get('kernel')->getProjectDir() . "public/excel/receipt.xlsx");
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('F4', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');

//        $spreadsheet = $this->get('phpexcel')->create
    }
}