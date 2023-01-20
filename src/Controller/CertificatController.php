<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\Certificat;
use App\Form\CertificatType;
use App\Entity\Questionnaire;
use App\Service\QuestionnaireService;
use App\Repository\CertificatRepository;
use App\Repository\QuestionnaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/certificat")
 */
class CertificatController extends AbstractController
{
    public $qs;
    public $qR;
    public function __construct(QuestionnaireService $qs, QuestionnaireRepository $qR)
    {
        $this->qs = $qs;
        $this->qR = $qR;
    }
    /**
     * @Route("/", name="app_certificat_index", methods={"GET"})
     */
    public function index(CertificatRepository $certificatRepository): Response
    {
        return $this->render('certificat/index.html.twig', [
            'certificats' => $certificatRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_certificat_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CertificatRepository $certificatRepository): Response
    {
        $certificat = new Certificat();
        $form = $this->createForm(CertificatType::class, $certificat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $certificat->setUser($this->getUser());
            $certificatRepository->add($certificat, true);

            return $this->redirectToRoute('coneil_patient', ['id'=>$this->qs->questionnaireByCertificat($certificat->getId())->getConseil()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('certificat/new.html.twig', [
            'certificat' => $certificat,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_certificat_show", methods={"GET"})
     */
    public function show(Certificat $certificat): Response
    {
        return $this->render('certificat/show.html.twig', [
            'certificat' => $certificat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_certificat_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Certificat $certificat, CertificatRepository $certificatRepository): Response
    {
        $form = $this->createForm(CertificatType::class, $certificat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $certificat->setUser($this->getUser());
            $certificatRepository->add($certificat, true);
            
            return $this->redirectToRoute('coneil_patient', ['id'=>$this->qs->questionnaireByCertificat($certificat->getId())->getConseil()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('certificat/edit.html.twig', [
            'certificat' => $certificat,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_certificat_delete", methods={"POST"})
     */
    public function delete(Request $request, Certificat $certificat, CertificatRepository $certificatRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$certificat->getId(), $request->request->get('_token'))) {
            $certificatRepository->remove($certificat, true);
        }

        return $this->redirectToRoute('app_certificat_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/delete/{id}", name="app_delete_certificat", methods={"GET"})
     */
    public function deleteCertificat(Request $request, Certificat $certificat, CertificatRepository $certificatRepository): Response
    {
       // dd($certificat);
        if ($certificat) {
            $questionnaire = $this->qs->questionnaireByCertificat($certificat->getId());
            $questionnaire->setCertificat(new Certificat());
            $this->qR->add($questionnaire);
            $certificatRepository->remove($certificat, true);
            return $this->redirectToRoute('coneil_patient', ['id'=>$this->qs->questionnaireByCertificat($certificat->getId())->getConseil()->getId()], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/new/{id}", name="app_certificat_new_patient")
     */
    public function newWithPathient(Questionnaire $questionnaire, Request $request, CertificatRepository $certificatRepository, QuestionnaireRepository $questionnaireRepository): Response
    {
        $certificat = new Certificat();
        $form = $this->createForm(CertificatType::class, $certificat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $certificatRepository->add($certificat, true);
            //$questionnaire = $patient->getQuestionnaires()->last();
            $questionnaire->setCertificat($certificat);
            $questionnaireRepository->add($questionnaire, true);
            return $this->redirectToRoute('coneil_patient', ['id'=>$questionnaire->getConseil()->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('certificat/new.html.twig', [
            'certificat' => $certificat,
            'questionnaire' => $questionnaire,
            'form' => $form,
        ]);
    }
}