<?php

namespace App\Controller;

use Fpdf\Fpdf;
use Dompdf\Dompdf;
use App\Entity\Evasan;
use App\Repository\UserRepository;
use App\Repository\VisaRepository;
use App\Repository\PatientRepository;
use App\Twig\ArticleExtension;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/", name="app_home")
     */
    public function index(PatientRepository $patientRepository): Response
    {
        //return $this->redirectToRoute('app_login');
        return $this->render('home.html.twig');

         // return $this->render('pdf_generator/index.html.twig', [
        //     'controller_name' => 'PdfGeneratorController',
        // ]);
        
        /* $html =  $this->renderView('bilan.html.twig', ['patients' => $patientRepository->findAll()]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
         
        return new Response (
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        ); */
    }


    
    
    /**
     * @Route("/decision/{id}", name="app_home_test")
     */
    public function FunctionName(Request $request, Evasan $evasan, VisaRepository $visaRepository, ArticleExtension $articleExtension)
    {
        //dd($articleExtension->art2($evasan));
        //dd($visaRepository->findAll()[1]->getVisa());
        $vu = $visaRepository->findAll()[0]->getVisa();
        //dd($vu);
        //return $this->render('questionnaire/testa.html.twig');
        //dd($questionnaireService->questionnaireByPatientAndConseil(4,4));
        $pdf = new Fpdf();
        $pdf->AddPage();
        //$pdf->SetFont('Times', 'B', 13);
        //$widthSP = $pdf->GetStringWidth('LE MINISTRE DE LA FONCTION PUBLIQUE ET DU RENOUVEAU DU,');
        //dd($widthSP);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetX(10);
        $pdf->Cell(0, 10 , 'REPUBLIQUE DU SENEGAL', 0, 0, 'L');
        //$pdf->SetX(10);
        $pdf->Cell(0, 10 , utf8_decode('N°                             MFPRSP/CMSFP/CS'),0, 0, 'R');
        $pdf->Ln(6);
        $pdf->SetFont('Times', 'I', 7);
        $pdf->SetX(13);
        $pdf->Cell(0,10,'Un Peuple - Un But - Une Foi',false);
        $pdf->ln(6);
        $pdf->SetX(25);
        $pdf->Cell(0, 10, '......................', false);
        $pdf->ln(6);
        $pdf->SetX(10);
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(0,10,'Ministere de la fonction publique, et du',false);
        $pdf->ln(6);
        $pdf->SetX(15);
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(0,10,'Renouveau du Service public',false);
        $pdf->ln(6);
        $pdf->SetFont('Times', '', 11);
        //$pdf->SetRightMargin(20);
        // $pdf->Cell(0, 10, utf8_decode('Décision portant autorisation d\'évacuation'), 0, 0, 'R');
        // $pdf->ln(6);
        $pdf->SetFont('Times', '', 12);
        $pdf->SetX(110);
        if ($evasan->getQuestionnaire()->getPatient()->getSexe() == 0) {
            $civilite = "Monsieur ";
            $compagnon = "accompagné";
        } else {
            $civilite = "Monsieur ";
            $compagnon = "accompagnée";
        }

        $patient = $civilite." ". $evasan->getQuestionnaire()->getPatient()->getPrenom()." ".$evasan->getQuestionnaire()->getPatient()->getNom().", ".$evasan->getQuestionnaire()->getPatient()->getCorps()->getNom().", matricule de solde ".$evasan->getQuestionnaire()->getPatient()->getMatricule()." ".$compagnon;
        //777756737
        
        $pdf->MultiCell(0, 6, utf8_decode('Décision portant autorisation d\'évacuation sanitaire de '.$patient.' '.$evasan->getAccompagnant()), 'J');
        //$pdf->Cell(0, 10, 'CONSEIL DE SANTE', 0, 0, 'C');
        $pdf->ln(6);
        $pdf->SetFont('Times', 'B', 13);
        $pdf->SetX(30);
        $pdf->Cell(0, 6, utf8_decode('LE MINISTRE DE LA FONCTION PUBLIQUE ET DU RENOUVEAU DU'), 'C');
        $pdf->ln(6);
        $pdf->SetX(85);
        
        $pdf->Cell(0, 6, utf8_decode('SERVICE PUBLIC,'), 'C');
        $pdf->Ln(10);
        $pdf->SetFont('Times', '', 10);
        $pdf->MultiCell(0, 6, utf8_decode($vu));

        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 10 , 'DECIDE :', 0, 0, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('Times', 'U', 12);
        $cell = "Article premier.-";
        $pdf->Cell($pdf->GetStringWidth($cell),6,$cell, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $patient = $civilite." ". $evasan->getQuestionnaire()->getPatient()->getPrenom()." ".$evasan->getQuestionnaire()->getPatient()->getNom().", ".$evasan->getQuestionnaire()->getPatient()->getCorps()->getNom().", matricule de solde ".$evasan->getQuestionnaire()->getPatient()->getMatricule().", en service ".$evasan->getQuestionnaire()->getPatient()->getLieuService()." ".$compagnon." ".$evasan->getAccompagnant().", ".$evasan->getDestination();
        $pdf->MultiCell(0, 6, utf8_decode(' Est autorisée l\'évacuation sanitaire de '.$articleExtension->art1($evasan)));
        $pdf->SetFont('Times', 'BI', 12);
        $pdf->Ln(10);
        $pdf->SetFont('Times', 'U', 12);
        $string = "Article 2.-";
        $pdf->Cell($pdf->GetStringWidth($string),6,$string, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->MultiCell(0, 6, utf8_decode($articleExtension->art2($evasan)));
        // 
        $pdf->Ln(10);
        $pdf->SetFont('Times', 'U', 12);
        $string = "Article 3.-";
        $pdf->Cell($pdf->GetStringWidth($string),6,$string, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->MultiCell(0, 6, utf8_decode(' Les frais de transport aérien aller-retour vers le pays d\'accueil sont à la charge de l\'Etat.'));
        /* Article 4 je récupère l'information au niveau de la base de donnée */
        $art4 = $visaRepository->findAll()[1]->getVisa();

        $pdf->Ln(10);
        $pdf->SetFont('Times', 'U', 12);
        $string = "Article 4. -";
        $pdf->Cell($pdf->GetStringWidth($string),6,$string, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->MultiCell(0, 6, utf8_decode($articleExtension->art4($evasan)));
        $pdf->Ln(10);
        $pdf->SetFont('Times', 'U', 12);
        $string = "Article 5. -";
        $pdf->Cell($pdf->GetStringWidth($string),6,$string, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->MultiCell(0, 6, utf8_decode(' La présente décision sera enregistrée, publiée et communiquée partout où besoin sera.'));
        $pdf->SetY(210);
        $pdf->Cell(0, 10 , 'AMPLIATIONS :');
        $pdf->SetFont('Times', '', 12);
        $pdf->ln(6);
        $pdf->Cell(0, 10 , 'SGG');
        $pdf->ln(6);
        $pdf->Cell(0, 10 , 'MFPRSP');
        $pdf->ln(6);
        $pdf->Cell(0, 10 , 'MFPRSP/CS');
        $pdf->ln(6);
        $pdf->Cell(0, 10 , 'MFB/DGB');
        $pdf->ln(6);
        $pdf->Cell(0, 10 , 'CF');
        $pdf->ln(6);
        $pdf->Cell(0, 10 , 'CHRONO');
        $pdf->ln(6);
        $pdf->Cell(0, 10 , 'INTERESSE');
        $pdf->ln(6);
        $pdf->Cell(0, 10 , 'ARCHIVES NATIONALES');

        

        
        $pdf->Output('test.pdf', 'I');
        dd("true");
    }
}