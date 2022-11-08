<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use App\Service\Censurator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/wish/create", name="wish_create")
     */
    public function create(EntityManagerInterface $entityManager, Request $request, Censurator $censurator) {
        $wish = new Wish();
        $wish->setIsPublished(true);
        $wish->setDateCreated(new \DateTime());

        $wishForm = $this->createForm(WishType::class, $wish);
        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            $wish->setDescription($censurator->purify($wish->getDescription()));
            $entityManager->persist($wish);
            $entityManager->flush();
            $this->addFlash('success', 'You made a new wish!');
            return $this->redirectToRoute('wish_details', ['id' => $wish->getId()]);
        }

        return $this->render('wish/create.html.twig', [
            'wishForm' => $wishForm->createView()
        ]);
    }
}
