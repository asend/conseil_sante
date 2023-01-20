<?php

namespace App\Controller;

use Dompdf\Dompdf;
use App\Entity\Conseil;
use App\Form\ConseilType;
use App\Form\ConseilPatientType;
use App\Repository\ConseilRepository;
use App\Repository\QuestionnaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER")
 * @Route("/conseil")
 */
class ConseilController extends AbstractController
{
    /**
     * @Route("/", name="app_conseil_index", methods={"GET"})
     */
    public function index(ConseilRepository $conseilRepository): Response
    {
        return $this->render('conseil/index.html.twig', [
            'conseils' => $conseilRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_conseil_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ConseilRepository $conseilRepository): Response
    {
        $conseil = new Conseil();
        $form = $this->createForm(ConseilType::class, $conseil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $conseilRepository->add($conseil, true);

            return $this->redirectToRoute('app_conseil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('conseil/new.html.twig', [
            'conseil' => $conseil,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_conseil_show", methods={"GET"})
     */
    public function show(Conseil $conseil): Response
    {
        return $this->render('conseil/show.html.twig', [
            'conseil' => $conseil,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_conseil_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Conseil $conseil, ConseilRepository $conseilRepository): Response
    {
        $form = $this->createForm(ConseilType::class, $conseil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $conseilRepository->add($conseil, true);

            return $this->redirectToRoute('app_conseil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('conseil/edit.html.twig', [
            'conseil' => $conseil,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_conseil_delete", methods={"POST"})
     */
    public function delete(Request $request, Conseil $conseil, ConseilRepository $conseilRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$conseil->getId(), $request->request->get('_token'))) {
            $conseilRepository->remove($conseil, true);
        }

        return $this->redirectToRoute('app_conseil_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/addPatient/{id}", name="app_conseil_patient")
     */
    public function addPatient(Request $request, Conseil $conseil, ConseilRepository $conseilRepository): Response
    {
        //$conseil = new Conseil();
        $form = $this->createForm(ConseilPatientType::class, $conseil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $conseilRepository->add($conseil, true);

            return $this->redirectToRoute('app_conseil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('conseil/addPatient.html.twig', [
            'conseil' => $conseil,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/patient/{id}", name="coneil_patient")
     */
    public function patient(Request $request, Conseil $conseil): Response
    {
        return $this->render('conseil/patient.html.twig', [
            'conseil' => $conseil,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_delete_conseil")
     */
    public function dleteConseil(Request $request, Conseil $conseil, ConseilRepository $conseilRepository, QuestionnaireRepository $questionnaireRepository): Response
    {
        foreach ($conseil->getQuestionnaire() as $questionnaire) {
            $questionnaireRepository->remove($questionnaire, true);
        }
        if (count($conseil->getQuestionnaire())==0) {
            $conseilRepository->remove($conseil, true);
        }
        
        return $this->redirectToRoute('app_conseil_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/deliberer/{id}", name="app_conseil_deliberer")
     */
    public function deliberer(Conseil $conseil): Response
    {
        $html =  $this->renderView('bilan.html.twig', ['conseil' => $conseil]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        return new Response (
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }
}