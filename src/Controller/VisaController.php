<?php

namespace App\Controller;

use App\Entity\Visa;
use App\Form\VisaType;
use App\Repository\VisaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/visa")
 */
class VisaController extends AbstractController
{
    /**
     * @Route("/", name="app_visa_index", methods={"GET"})
     */
    public function index(VisaRepository $visaRepository): Response
    {
        return $this->render('visa/index.html.twig', [
            'visas' => $visaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_visa_new", methods={"GET", "POST"})
     */
    public function new(Request $request, VisaRepository $visaRepository): Response
    {
        $visa = new Visa();
        $form = $this->createForm(VisaType::class, $visa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $visaRepository->add($visa, true);

            return $this->redirectToRoute('app_visa_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('visa/new.html.twig', [
            'visa' => $visa,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_visa_show", methods={"GET"})
     */
    public function show(Visa $visa): Response
    {
        return $this->render('visa/show.html.twig', [
            'visa' => $visa,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_visa_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Visa $visa, VisaRepository $visaRepository): Response
    {
        $form = $this->createForm(VisaType::class, $visa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $visaRepository->add($visa, true);

            return $this->redirectToRoute('app_visa_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('visa/edit.html.twig', [
            'visa' => $visa,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_visa_delete", methods={"POST"})
     */
    public function delete(Request $request, Visa $visa, VisaRepository $visaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$visa->getId(), $request->request->get('_token'))) {
            $visaRepository->remove($visa, true);
        }

        return $this->redirectToRoute('app_visa_index', [], Response::HTTP_SEE_OTHER);
    }
}
