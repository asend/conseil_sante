<?php

namespace App\Controller;

use App\Entity\Specialite;
use App\Form\SpecialiteType;
use App\Repository\SpecialiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/specialite')]
class SpecialiteController extends AbstractController
{
    #[Route('/', name: 'app_specialite_index', methods: ['GET'])]
    public function index(SpecialiteRepository $specialiteRepository): Response
    {
        return $this->render('specialite/index.html.twig', [
            'specialites' => $specialiteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_specialite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SpecialiteRepository $specialiteRepository): Response
    {
        $specialite = new Specialite();
        $form = $this->createForm(SpecialiteType::class, $specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specialiteRepository->add($specialite, true);

            return $this->redirectToRoute('app_specialite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('specialite/new.html.twig', [
            'specialite' => $specialite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_specialite_show', methods: ['GET'])]
    public function show(Specialite $specialite): Response
    {
        return $this->render('specialite/show.html.twig', [
            'specialite' => $specialite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_specialite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Specialite $specialite, SpecialiteRepository $specialiteRepository): Response
    {
        $form = $this->createForm(SpecialiteType::class, $specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specialiteRepository->add($specialite, true);

            return $this->redirectToRoute('app_specialite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('specialite/edit.html.twig', [
            'specialite' => $specialite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_specialite_delete', methods: ['POST'])]
    public function delete(Request $request, Specialite $specialite, SpecialiteRepository $specialiteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$specialite->getId(), $request->request->get('_token'))) {
            $specialiteRepository->remove($specialite, true);
        }

        return $this->redirectToRoute('app_specialite_index', [], Response::HTTP_SEE_OTHER);
    }
}
