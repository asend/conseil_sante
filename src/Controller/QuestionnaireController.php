<?php

namespace App\Controller;

use Fpdf\Fpdf;
use App\Entity\Conseil;
use App\Entity\Evasan;
use App\Entity\Patient;
use App\Entity\Questionnaire;
use App\Form\QuestionnaireType;
use App\Repository\DemandeRepository;
use App\Repository\EvasanRepository;
use App\Repository\QuestionnaireRepository;
use App\Service\QuestionnaireService;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Console\Question\Question;

/**
 * @Route("/questionnaire")
 */
class QuestionnaireController extends AbstractController
{
    public $questionnaireService;
    public $userService;
    public function __construct(QuestionnaireService $questionnaireService, UserService $userService)
    {
        $this->questionnaireService = $questionnaireService;
        $this->userService = $userService;
    }
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/", name="app_questionnaire_index", methods={"GET"})
     */
    public function index(QuestionnaireRepository $questionnaireRepository): Response
    {
        return $this->render('questionnaire/index.html.twig', [
            'questionnaires' => $questionnaireRepository->findAll(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/new/{id}", name="app_questionnaire_new", methods={"GET", "POST"})
     */
    public function new(Request $request, QuestionnaireRepository $questionnaireRepository, Patient $patient): Response
    {
        //dd($patient);
        $questionnaire = new Questionnaire();
        $form = $this->createForm(QuestionnaireType::class, $questionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionnaire->setPatient($patient);
            //dd($request);
            $questionnaireRepository->add($questionnaire, true);

            return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('questionnaire/new.html.twig', [
            'questionnaire' => $questionnaire,
            'form' => $form,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}", name="app_questionnaire_show", methods={"GET"})
     */
    public function show(Questionnaire $questionnaire): Response
    {
        return $this->render('questionnaire/show.html.twig', [
            'questionnaire' => $questionnaire,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}/edit", name="app_questionnaire_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Questionnaire $questionnaire, QuestionnaireRepository $questionnaireRepository, DemandeRepository $demandeRepository, EvasanRepository $evasanRepository): Response
    {
        $form = $this->createForm(QuestionnaireType::class, $questionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($request->request->get('questionnaire')['q1'] == 0) {
                if (isset($request->request->get('questionnaire')['q2'])) {
                    for ($i=0; $i < count($request->request->get('questionnaire')['q2']); $i++) { 
                    $questionnaire->removeQ2($demandeRepository->find($request->request->get('questionnaire')['q2'][$i]));
                }
                }
                
            }
            if ($request->request->get('questionnaire')['q3'] == 1) {
                $questionnaire->setQ3datecessation(null);
            }
            if ($request->request->get('questionnaire')['q4'] == 1) {
                $questionnaire->setQ4datesuspension(null);
            }
            $questionnaireRepository->add($questionnaire, true);
            if ($request->request->get('questionnaire')['q8'] == 5) {
                if(!$evasanRepository->findByQuestionnaire($questionnaire->getId())){
                    $evasan = new Evasan();
                    $evasan->setQuestionnaire($questionnaire);
                    $evasanRepository->add($evasan, true);
                }
            }else{
                if ($evasanRepository->findByQuestionnaire($questionnaire->getId())) {
                    $evasanRepository->remove($evasanRepository->findByQuestionnaire($questionnaire->getId()), true);
                }
            }

            return $this->redirectToRoute('app_questionnaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('questionnaire/edit.html.twig', [
            'questionnaire' => $questionnaire,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit/{idC}/conseil/{idP}/patient", name="app_edit_questionnaire")
     * @ParamConverter("conseil", options={"mapping": {"idC" : "id"}})
     * @ParamConverter("patient", options={"mapping": {"idP" : "id"}})
     */
    public function editQuestionnaire(Request $request, Questionnaire $questionnaire, QuestionnaireRepository $questionnaireRepository, DemandeRepository $demandeRepository, EvasanRepository $evasanRepository, Conseil $conseil, Patient $patient): Response
    {
        //dd($request->request);
        //dd($questionnaireRepository->otherQuestion($conseil, $patient));
        $form = $this->createForm(QuestionnaireType::class, $questionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            if ($request->request->get('questionnaire')['q1'] == 0) {
                if (isset($request->request->get('questionnaire')['q2'])) {
                    for ($i=0; $i < count($request->request->get('questionnaire')['q2']); $i++) { 
                    $questionnaire->removeQ2($demandeRepository->find($request->request->get('questionnaire')['q2'][$i]));
                }
                }
                
            }
            if ($request->request->get('questionnaire')['q3'] == 1) {
                $questionnaire->setQ3datecessation(null);
            }
            if ($request->request->get('questionnaire')['q4'] == 1) {
                $questionnaire->setQ4datesuspension(null);
            }
            $questionnaireRepository->add($questionnaire, true);
            if ($request->request->get('questionnaire')['q8'] == 5) {
                if(!$evasanRepository->findByQuestionnaire($questionnaire->getId())){
                    $evasan = new Evasan();
                    $evasan->setQuestionnaire($questionnaire);
                    $evasanRepository->add($evasan, true);
                }
            }else{
                if ($evasanRepository->findByQuestionnaire($questionnaire->getId())) {
                    $evasanRepository->remove($evasanRepository->findByQuestionnaire($questionnaire->getId()), true);
                }
            }
            return $this->redirectToRoute('coneil_patient', ['id'=>$conseil->getId()]);
            //return $this->redirectToRoute('app_questionnaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('questionnaire/edit.html.twig', [
            'questionnaire' => $questionnaire,
            'questionnaires' => $questionnaireRepository->otherQuestion($conseil, $patient),
            'form' => $form,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}", name="app_questionnaire_delete", methods={"POST"})
     */
    public function delete(Request $request, Questionnaire $questionnaire, QuestionnaireRepository $questionnaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$questionnaire->getId(), $request->request->get('_token'))) {
            $questionnaireRepository->remove($questionnaire, true);
        }

        return $this->redirectToRoute('app_questionnaire_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/delete/{id}", name="app_delete_questionnaire")
     */
    public function deleteQuestionnaire(Request $request, Questionnaire $questionnaire, QuestionnaireRepository $questionnaireRepository): Response
    {
        if ($questionnaire) {
            $conseil = $questionnaire->getConseil();
            $questionnaireRepository->remove($questionnaire, true);
            return $this->redirectToRoute('coneil_patient', ['id'=>$conseil->getId()]);
        }
        return $this->redirectToRoute('app_conseil_index');
        
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/conseil/patient/{idC}/{idP}", name="app_questionnaire_conseil_patient_new", methods={"GET", "POST"})
     * @ParamConverter("conseil", options={"mapping": {"idC" : "id"}})
     * @ParamConverter("patient", options={"mapping": {"idP" : "id"}})
     */
    public function newConseilPatient(Request $request, Conseil $conseil, Patient $patient, QuestionnaireRepository $questionnaireRepository, EvasanRepository $evasanRepository): Response
    {
        //dd($questionnaireRepository->otherQuestion($request->query->get('idC'), $request->query->get('idP')));
        $questionnaire = new Questionnaire();
        $form = $this->createForm(QuestionnaireType::class, $questionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionnaire->setPatient($patient);
            $questionnaire->setConseil($conseil);
            $questionnaireRepository->add($questionnaire, true);
            if ($request->request->get('questionnaire')['q8'] == 5) {
                if(!$evasanRepository->findByQuestionnaire($questionnaire->getId())){
                    $evasan = new Evasan();
                    $evasan->setQuestionnaire($questionnaire);
                    $evasanRepository->add($evasan, true);
                }
            }
            return $this->redirectToRoute('coneil_patient', ['id'=>$conseil->getId()]);

            //return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('questionnaire/new.html.twig', [
            'questionnaire' => $questionnaire,
            'conseil' => $conseil,
            'questionnaires' => $questionnaireRepository->otherQuestion($conseil, $patient),
            'form' => $form,
        ]);
    }

    /**
     * @Route("/conseil/{idC}/patient/{idP}", name="app_questionnaire_conseil_patient_new_test")
     * @ParamConverter("conseil", options={"mapping": {"idC" : "id"}})
     * @ParamConverter("patient", options={"mapping": {"idP" : "id"}})
     */
    public function FunctionName(Request $request, Conseil $conseil, Patient $patient, QuestionnaireRepository $questionnaireRepository, EvasanRepository $evasanRepository): Response
    {
        //dd($request);
        dd($questionnaireRepository->otherQuestion($conseil, $patient));
    }

    /**
     * @Route("/certificat/{id}", name="app_questionnaire_ceritificat", methods={"GET","POST"})
     */
    public function certificat(Questionnaire $questionnaire){
        $patient = $questionnaire->getPatient();
        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 8);
        $pdf->SetX(10);
        $pdf->Cell(0, 10 , 'REPUBLIQUE DU SENEGAL', 0, 0, 'L');
        //$pdf->SetX(10);
        $pdf->Cell(0, 10 , utf8_decode('N°                             MFPRSP/CMSFP/CS'),0, 0, 'R');
        $pdf->Ln(6);
        $pdf->SetFont('Times', 'I', 7);
        $pdf->SetX(13);
        $pdf->Cell(0,10, utf8_decode('Un Peuple - Un But - Une Foi') ,false);
        $pdf->ln(6);
        $pdf->SetX(25);
        $pdf->Cell(0, 10, '......................', false);
        $pdf->ln(6);
        $pdf->SetX(10);
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(0,10, utf8_decode('Ministere de la fonction publique, et du'),false);
        $pdf->ln(6);
        $pdf->SetX(15);
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(0,10, utf8_decode('Renouveau du Service public') ,false);
        $pdf->ln(6);
        $pdf->SetX(25);
        $pdf->Cell(0, 10, '......................', false);
        $pdf->ln(6);
        $pdf->SetX(10);
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(0,10, utf8_decode('Centre Medico-social de la Fonction publique') ,false);
        $pdf->ln(6);
        $pdf->SetX(22);
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(0,10, utf8_decode('Le Conseil de Sante'), false);
        $pdf->ln(6);
        $pdf->SetFont('Times', 'B', 11);
        $pdf->Cell(0, 10, utf8_decode('CERTIFICAT DE VISITE'), 0, 0, 'C');
        $pdf->ln(6);
        $pdf->SetFont('Times', 'B', 11);
        $pdf->Cell(0, 10, utf8_decode('CONSEIL DE SANTE'), 0, 0, 'C');
        $pdf->ln(6);
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(0, 10, '***********', 0, 0, 'C');
        $pdf->ln(10);
        $pdf->setX(20);
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(0, 10 , utf8_decode('Nous soussignés, membres du Conseil de Sante de Dakar, certifions que :') , 0, 0, false);
        $pdf->ln(6);
        $pdf->setX(20);
        $pdf->SetFont('Times', 'B', 10);
        /** cellule */
        if ($patient->getSexe() == 0) {
            $cell = 'Monsieur '.ucfirst($patient->getPrenom()).' '.strtoupper ($patient->getNom());
        } else {
            $cell ='Madame '. ucfirst($patient->getPrenom()).' '.strtoupper ($patient->getNom());  
        }
        $pdf->Cell($pdf->GetStringWidth($cell),10, utf8_decode($cell), 0, 'L');
        
        //$pdf->setX(20+$pdf->GetStringWidth($cell));
        $pdf->SetFont('Times','',10);
        $pdf->Cell(0, 10 , utf8_decode(', I P2, matricule de solde 629 207/D en service à '.$patient->getAdresse()) , 0, 0, 'L');
        $pdf->ln(6);
        $pdf->setX(20);
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(0, 10 , utf8_decode('Né(e) le '.$patient->getDateNaissance()->format("d/m/Y").' à '.$patient->getLieuNaissance()) , 0, 0, false);
        $pdf->ln(6);
        $pdf->setX(20);
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(0, 10 , utf8_decode('Présenté au Conseil de Santé par le Médecin Chef du Centre Médico-social de la Fonction publique '.$this->userService->getMedecinChef()->getNomComplet().'.') , 0, 0, false);
        $pdf->ln(6);
        $pdf->setX(20);
        $pdf->SetFont('Times', '', 10);
        $pathologie = $questionnaire->getCertificat()->getPathologie() ? $questionnaire->getCertificat()->getPathologie()->getNom() : 'NA';
        $pdf->Cell(0, 10 , utf8_decode('Agissant conformément aux préscriptions des textes en vigueur, est atteint(e) de (état actuel) : '.$pathologie) , 0, 0, false);
        $pdf->ln(24);
        $pdf->setX(20);
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(0, 10 , utf8_decode('Estimons en conséquence = Décision du Conseil :') , 0, 0, false);
        $pdf->ln(24);
        //$pdf->setX(20);
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(0, 10 , utf8_decode('Fait à Dakar, le '.$questionnaire->getConseil()->getDateConseil()->format("d/m/Y")) , 0, 0, 'R');
        $pdf->ln(8);
        //$pdf->setX(20);
        $pdf->SetFont('Times', 'BU', 10);
        $pdf->Cell(0, 10 , utf8_decode('Le Président') , 0, 0, false);
        //$pdf->setX(20);
        $pdf->SetFont('Times', 'BU', 10);
        $pdf->Cell(0, 10 , utf8_decode('Les Membres du Conséil de Santé') , 0, 0, 'R');
        $pdf->Output('test.pdf', 'I');
        dd("true");
    }
}