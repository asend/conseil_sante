<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Patient;
use App\Form\PatientType;
use App\Repository\CadreRepository;
use App\Repository\CorpsRepository;
use App\Repository\PatientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER")
 * @Route("/patient")
 */
class PatientController extends AbstractController
{
    /**
     * @Route("/", name="app_patient_index", methods={"GET"})
     */
    public function index(PatientRepository $patientRepository): Response
    {
        return $this->render('patient/index.html.twig', [
            'patients' => $patientRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_patient_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PatientRepository $patientRepository, CadreRepository $cadreRepository, CorpsRepository $corpsRepository): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($request);
            $patient->setCadre($cadreRepository->find($request->get('cadre')));
            $patient->setCorps($corpsRepository->find($request->get('corps')));
            $patientRepository->add($patient, true);

            return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('patient/new.html.twig', [
            'patient' => $patient,
            'cadres' => $cadreRepository->findAll(),
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_patient_show", methods={"GET"})
     */
    public function show(Patient $patient): Response
    {
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);

        // Configure Dompdf according to your needs
        // $pdfOptions = new Options();
        // $pdfOptions->set('defaultFont', 'Arial');
        
        // // Instantiate Dompdf with our options
        // $dompdf = new Dompdf($pdfOptions);
        
        // // Retrieve the HTML generated in our twig file
        // $html = $this->renderView('patient/pdf.html.twig', [
        //     'patient' => $patient,
        //     'title' => "Welcome to our PDF Test"
        // ]);
        
        // // Load HTML to Dompdf
        // $dompdf->loadHtml($html);
        
        // // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        // $dompdf->setPaper('A4', 'portrait');

        // // Render the HTML as PDF
        // $dompdf->render();

        // // Output the generated PDF to Browser (force download)
        // $dompdf->stream('mypdf.pdf', [
        //     'Attachment' => true
        // ]);
    }

    /**
     * @Route("/{id}/edit", name="app_patient_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Patient $patient, PatientRepository $patientRepository, CadreRepository $cadreRepository, CorpsRepository $corpsRepository): Response
    {
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patient->setCadre($cadreRepository->find($request->get('cadre')));
            $patient->setCorps($corpsRepository->find($request->get('corps')));
            $patientRepository->add($patient, true);

            return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('patient/edit.html.twig', [
            'patient' => $patient,
            'cadres' => $cadreRepository->findAll(),
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_patient_delete", methods={"POST"})
     */
    public function delete(Request $request, Patient $patient, PatientRepository $patientRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patient->getId(), $request->request->get('_token'))) {
            $patientRepository->remove($patient, true);
        }

        return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/delete/{id}", name="app_delete_patient")
     */
    public function deletePatient(Request $request, Patient $patient, PatientRepository $patientRepository): Response
    {
        // if (count($patient->getConseils()) == 0) {
        //     dd("ok");
        // } else {
        //     dd("ko");
        // }
        
        if (count($patient->getConseils()) == 0) {
            $patientRepository->remove($patient, true);
        }
        return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);

    }
}