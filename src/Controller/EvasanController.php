<?php

namespace App\Controller;

use App\Entity\Evasan;
use App\Entity\Patient;
use App\Form\EvasanType;
use App\Entity\Questionnaire;
use App\Repository\EvasanRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/evasan")
 */
class EvasanController extends AbstractController
{
    /**
     * @Route("/", name="app_evasan_index", methods={"GET"})
     */
    public function index(EvasanRepository $evasanRepository): Response
    {
        return $this->render('evasan/index.html.twig', [
            'evasans' => $evasanRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_evasan_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EvasanRepository $evasanRepository): Response
    {
        $evasan = new Evasan();
        $form = $this->createForm(EvasanType::class, $evasan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evasanRepository->add($evasan, true);

            return $this->redirectToRoute('app_evasan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evasan/new.html.twig', [
            'evasan' => $evasan,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_evasan_show", methods={"GET"})
     */
    public function show(Evasan $evasan): Response
    {
        return $this->render('evasan/show.html.twig', [
            'evasan' => $evasan,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_evasan_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Evasan $evasan, EvasanRepository $evasanRepository): Response
    {
        $form = $this->createForm(EvasanType::class, $evasan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($request);
            $evasanRepository->add($evasan, true);

            return $this->redirectToRoute('coneil_patient', ['id'=>$evasan->getQuestionnaire()->getConseil()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evasan/edit.html.twig', [
            'evasan' => $evasan,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_evasan_delete", methods={"POST"})
     */
    public function delete(Request $request, Evasan $evasan, EvasanRepository $evasanRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evasan->getId(), $request->request->get('_token'))) {
            $evasanRepository->remove($evasan, true);
        }

        return $this->redirectToRoute('app_evasan_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{idE}/questionnaire/{idQ}", name="app_edit_evasan")
     * @ParamConverter("evasan", options={"mapping": {"idE" : "id"}})
     * @ParamConverter("questionnaire", options={"mapping": {"idQ" : "id"}})
     */
    public function editEvasan(Evasan $evasan, Questionnaire $questionnaire): Response
    {
        dd($evasan);
    }


    /**
     * @Route("/excel/generate/{id}", name="app_generate_excel")
     *
     * @return void
     */
    public function generateExcel(Evasan $evasan)
    {
        //dd($evasan->getQuestionnaire());
        $spreadsheet = new Spreadsheet();

        $patient = $evasan->getQuestionnaire()->getPatient();

        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'N°');
        $sheet->setCellValue('B1', 'PRENOM ET NOM');
        $sheet->setCellValue('B2', $patient->getPrenom()." ".$patient->getNom());
        $sheet->setCellValue('C1', 'STATUT');
        $sheet->setCellValue('D1', 'MINISTERE');
        $sheet->setCellValue('D2', $patient->getTutel()->getNom());
        $sheet->setCellValue('E1', 'DATE DE NAISSANCE');
        $sheet->setCellValue('E2', date_format($patient->getDateNaissance(), "d-m-Y") );
        $sheet->setCellValue('F1', 'SEXE');
        $sheet->setCellValue('F2', Patient::SEXE[$patient->getSexe()]);
        $sheet->setCellValue('G1', 'PATHOLOGIE');
        $sheet->setCellValue('H1', 'ACCOMPAGNANT');
        $sheet->setCellValue('H2', $evasan->getAccompagnant() ? $evasan->getAccompagnant() : "");
        $sheet->setCellValue('I1', 'DESTINATION');
        $sheet->setCellValue('I2', $evasan->getDestination());
        $sheet->setCellValue('J1', "NOMBRE D'EVACUATION");
        $sheet->setCellValue('K1', 'DEPART');
        $sheet->setCellValue('K2', $evasan->getDateDepart() ? date_format($evasan->getDateDepart(), "d-m-Y") : "");
        $sheet->setCellValue('L1', 'RETOUR');
        $sheet->setCellValue('L2', $evasan->getDateRetour() ? date_format($evasan->getDateRetour(), "d-m-Y") : "");
        $sheet->setCellValue('M1', 'FRAIS HOSPITALISATION ET SOINS');
        $sheet->setCellValue('N1', 'MONTANT');
        $sheet->setCellValue('N2', $evasan->getMontant() ? $evasan->getMontant() : "");
        $sheet->setCellValue('O1', 'RV CONTROLE');
        $sheet->setCellValue('O2', $evasan->getRvControle() ? $evasan->getRvControle() : "");
        $sheet->setCellValue('P1', 'DATE DEMANDE');
        $sheet->setCellValue('P2', $evasan->getDateDemande() ? date_format($evasan->getDateDemande(), "d-m-Y") : "");
        $sheet->setCellValue('Q1', 'N° BORDEREAU MINISTERE DE TUTELLE');
        $sheet->setCellValue('R1', 'DATE RECEPTION');
        $sheet->setCellValue('S1', "N° ET DATE DECISION");
        $sheet->setCellValue('T1', 'N° BORDEREAU FACTURE ET DATE DE TRANSMISSION A LA SOLDE');
        $sheet->setCellValue('U1', 'DATE VIREMENT');
        $sheet->setCellValue('V1', 'N° BULCI TRESOR');
        $sheet->setTitle("FICHE EVASAN");

        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);
        $fileName = 'my_first_excel_symfony4.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);

        // // In this case, we want to write the file in the public directory
        // $publicDirectory = '';// $this->get('kernel')->getProjectDir() . '/public';
        // // e.g /var/www/project/public/my_first_excel_symfony4.xlsx
        // $excelFilepath =  $publicDirectory . 'my_first_excel_symfony4.xlsx';

        // // Create the file
        // $writer->save($excelFilepath);

        // // Return a text response to the browser saying that the excel was succesfully created
        // return new Response("Excel generated succesfully");
        // //return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }
}