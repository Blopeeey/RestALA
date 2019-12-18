<?php

namespace App\Controller;

use App\Entity\Reservering;
use App\Form\ReserveringType;
use App\Repository\ReserveringRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reservering")
 */
class ReserveringController extends AbstractController
{
    /**
     * @Route("/", name="reservering_index", methods={"GET"})
     */
    public function index(ReserveringRepository $reserveringRepository): Response
    {
        return $this->render('reservering/index.html.twig', [
            'reserverings' => $reserveringRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="reservering_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reservering = new Reservering();
        $form = $this->createForm(ReserveringType::class, $reservering);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $today = new \DateTime();
            $datum = $form['datum']->getData();
            $stijd = $form['start_tijd']->getData();
            $etijd = $form['eind_tijd']->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $em = $entityManager->getRepository(reservering::class);
            if($em->findBy(['datum' => $datum]) == true) {
                if($em->findBy(['start_tijd' => $stijd]) == true) {
                    if ($em->findBy(['eind_tijd' => $etijd]) == true) {
                        return $this->redirectToRoute('reservering_index');
                    }
                    else{
                        $entityManager->persist($reservering);
                        $entityManager->flush();

                        return $this->redirectToRoute('reservering_index');
                    }
                }
                else{
                    $entityManager->persist($reservering);
                    $entityManager->flush();
                    return $this->redirectToRoute('reservering_index');
                }
            }
            else{
            $entityManager->persist($reservering);
            $entityManager->flush();
            return $this->redirectToRoute('reservering_index');
            }
        }
        return $this->render('reservering/new.html.twig', [
            'reservering' => $reservering,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservering_show", methods={"GET"})
     */
    public function show(Reservering $reservering): Response
    {
        return $this->render('reservering/show.html.twig', [
            'reservering' => $reservering,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservering_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reservering $reservering): Response
    {
        $form = $this->createForm(ReserveringType::class, $reservering);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservering_index');
        }

        return $this->render('reservering/edit.html.twig', [
            'reservering' => $reservering,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservering_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reservering $reservering): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservering->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservering);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservering_index');
    }
}
