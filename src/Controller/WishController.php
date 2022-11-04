<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/wish/list", name="wish_list")
     */
    public function list(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findBy([], ['dateCreated' => 'DESC']);
        return $this->render('wish/list.html.twig', ['wishes' => $wishes]);
    }

    /**
     * @Route("/wish/details/{id}", name="wish_details")
     */
    public function details(int $id, WishRepository $wishRepository) {
        $wish = $wishRepository->find($id);
        dump($wish);
        return $this->render('wish/details.html.twig', ['wish' => $wish]);
    }
}
