<?php

namespace App\Controller;

use App\Entity\Souhait;
use App\Form\SouhaitType;
use App\Repository\SouhaitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/souhait')]
class SouhaitController extends AbstractController
{
    #[Route('/', name: 'app_souhait_index', methods: ['GET'])]
    public function index(SouhaitRepository $souhaitRepository): Response
    {
        return $this->render('souhait/index.html.twig', [
            'souhaits' => $souhaitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_souhait_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SouhaitRepository $souhaitRepository): Response
    {
        $souhait = new Souhait();
        $form = $this->createForm(SouhaitType::class, $souhait);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $souhaitRepository->add($souhait, true);

            return $this->redirectToRoute('app_souhait_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('souhait/new.html.twig', [
            'souhait' => $souhait,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_souhait_show', methods: ['GET'])]
    public function show(Souhait $souhait): Response
    {
        return $this->render('souhait/show.html.twig', [
            'souhait' => $souhait,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_souhait_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Souhait $souhait, SouhaitRepository $souhaitRepository): Response
    {
        $form = $this->createForm(SouhaitType::class, $souhait);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $souhaitRepository->add($souhait, true);

            return $this->redirectToRoute('app_souhait_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('souhait/edit.html.twig', [
            'souhait' => $souhait,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_souhait_delete', methods: ['POST'])]
    public function delete(Request $request, Souhait $souhait, SouhaitRepository $souhaitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$souhait->getId(), $request->request->get('_token'))) {
            $souhaitRepository->remove($souhait, true);
        }

        return $this->redirectToRoute('app_souhait_index', [], Response::HTTP_SEE_OTHER);
    }
}
