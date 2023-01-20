<?php

namespace App\Controller;

use App\Entity\Pathologie;
use App\Form\PathologieType;
use App\Repository\PathologieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pathologie')]
class PathologieController extends AbstractController
{
    #[Route('/', name: 'app_pathologie_index', methods: ['GET'])]
    public function index(PathologieRepository $pathologieRepository): Response
    {
        return $this->render('pathologie/index.html.twig', [
            'pathologies' => $pathologieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pathologie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PathologieRepository $pathologieRepository): Response
    {
        $pathologie = new Pathologie();
        $form = $this->createForm(PathologieType::class, $pathologie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pathologieRepository->add($pathologie, true);

            return $this->redirectToRoute('app_pathologie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pathologie/new.html.twig', [
            'pathologie' => $pathologie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pathologie_show', methods: ['GET'])]
    public function show(Pathologie $pathologie): Response
    {
        return $this->render('pathologie/show.html.twig', [
            'pathologie' => $pathologie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pathologie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pathologie $pathologie, PathologieRepository $pathologieRepository): Response
    {
        $form = $this->createForm(PathologieType::class, $pathologie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pathologieRepository->add($pathologie, true);

            return $this->redirectToRoute('app_pathologie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pathologie/edit.html.twig', [
            'pathologie' => $pathologie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pathologie_delete', methods: ['POST'])]
    public function delete(Request $request, Pathologie $pathologie, PathologieRepository $pathologieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pathologie->getId(), $request->request->get('_token'))) {
            $pathologieRepository->remove($pathologie, true);
        }

        return $this->redirectToRoute('app_pathologie_index', [], Response::HTTP_SEE_OTHER);
    }
}
