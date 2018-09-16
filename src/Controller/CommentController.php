<?php
/**
 * Created by PhpStorm.
 * User: apetrou
 * Date: 14/09/2018
 * Time: 00:52
 */

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CustomerRepository;
use App\Repository\ProductOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\PurchaseController;
use App\Manager\ExcelManager;

class CommentController extends Controller
{
    /**
     * @Route("/new", name="comment_new")
     */
    public function new(Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $comment->setDateAdded(new \DateTime());
            $comment->setChecked(0);
            $comment->setRoute($request->getUri());

            $em->persist($comment);
            $em->flush();
        }

        return $this->render('comment/_form.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }
}