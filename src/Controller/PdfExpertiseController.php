<?php

namespace App\Controller;

use App\Entity\Questionnaire;
use App\Service\PdfService;
use Fpdf\Fpdf;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class PdfExpertiseController extends AbstractController
{
    /**
     * @Route("/pdf/expertise/{id}", name="app_pdf_expertise")
     */
    public function index(PdfService $pdfService, Request $request, TranslatorInterface $translatorInterface, Questionnaire $questionnaire): Response
    {
        /**
         * Patient|null
         */
        $patient = $questionnaire->getPatient();
        //dd($translatorInterface->trans('structure'));
        $pdf = $pdfService->headerPage();
        $pdf->Ln(10);
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(0, 10 , utf8_decode('Objet : DEMANDE D\'EXPERTISE MEDICALE') , 0, 0, false);
        $pdf->Ln(6);
        $pdf->Cell(0, 10 , utf8_decode('Cher Docteur,') , 0, 0, false);
        $pdf->Ln(6);
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell($pdf->GetStringWidth('Au terme des '), 10 , utf8_decode('Au terme des ') , 0, 0, 'L');
        $pdf->SetFont('Times','B',10);
        $pdf->Cell(0, 10 , utf8_decode('décrets :') , 0, 0, 'L');
        $pdf->Ln(6);
        $pdf->SetFont('Times','B',10);
        $pdf->SetX(20);
        $pdf->Cell($pdf->GetStringWidth('. n°63 - 116'), 10 , utf8_decode('. n°63 - 116') , 0, 0, 'L');
        $pdf->SetFont('Times');
        $pdf->MultiCell(0, 10, utf8_decode(' du 19 février 1963 relative au régime des congés, permissions et autorisations d\'absence des fonctionnaires,'));
        //$pdf->Ln(6);
        $pdf->SetFont('Times','B',10);
        $pdf->SetX(20);
        $pdf->Cell($pdf->GetStringWidth('. n° 2005 - 566'), 10 , utf8_decode('. n° 2005 - 566') , 0, 0, 'L');
        $pdf->SetFont('Times');
        $pdf->MultiCell(0, 10, utf8_decode(' du 22 juin 2005 concernant le Conseil de Santé et les évacuations sanitaires.'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(0, 10 , utf8_decode('Le conseil donne son avis sur des questions de santé relatives notamment ') , 0, 0, 'L');
        $pdf->Ln(6);
        $pdf->SetX(20);
        $pdf->Cell(0, 10 , utf8_decode('- à l\'aptitude professionnelle,') , 0, 0, 'L');
        $pdf->Ln(6);
        $pdf->SetX(20);
        $pdf->Cell(0, 10 , utf8_decode('- aux congés de maladie,') , 0, 0, 'L');
        $pdf->Ln(6);
        $pdf->SetX(20);
        $pdf->Cell(0, 10 , utf8_decode('- aux congés de longue durée,') , 0, 0, 'L');
        $pdf->Ln(6);
        $pdf->SetX(20);
        $pdf->Cell(0, 10 , utf8_decode('- aux changements d\'activités pour raison de santé,') , 0, 0, 'L');
        $pdf->Ln(6);
        $pdf->SetX(20);
        $pdf->Cell(0, 10 , utf8_decode('- aux évacuations sanitaires en dehors du territoire national,') , 0, 0, 'L');
        $pdf->Ln(6);
        $pdf->SetFont('Times', '', 10);
        $pdf->MultiCell(0, 10 , utf8_decode('Pour ce, le Président du Conseil soumet l\'agent à une expertise médicale réalisée par un spécialiste pour l\'affection en cause, en vue de la présentation des dossiers médicaux à la commision d\'évaluation et de décision.') );
        $pdf->Cell(0, 10 , utf8_decode('A cet effet, nous vous prions de bien vouloir examiner :') , 0, 0, 'L');
        $pdf->Ln(10);
        $pdf->SetFont('Times','B',12);
        if ($patient->getSexe() == 0) {
            $civilite = "Monsieur ";
        }else {
            $civilite = "Madame ";
        }
        $pdf->MultiCell(0, 10, utf8_decode($civilite." ".$patient->getPrenom()." ".$patient->getNom()));
        $pdf->SetFont('Times','',12);
        $pdf->Cell(0, 10 , utf8_decode('aux fins de :') , 0, 0, 'L');
        $pdf->Ln(6);
        $pdf->SetX(20);
        $pdf->SetFont('Times', '', 10);
        $pdf->MultiCell(0, 10, utf8_decode('décrire la nature de la maladie ;'));
        $pdf->SetX(20);
        $pdf->MultiCell(0, 10, utf8_decode('nous édifier sur la possibilité de guérison ;'));
        $pdf->SetX(20);
        $pdf->MultiCell(0, 10, utf8_decode('ou, si au contraire cette affection nécessite un congé de longue durée pour une meilleure prise en charge.'));
        $pdf->SetX(20);
        $pdf->MultiCell(0, 10, utf8_decode('Dans lattente de votre rapport accompagné de la note dhonoraires de Cinquante mille (50 000) francs, nous vous prions dagréer, Cher Docteur, lassurance de notre considération distinguée.'));
        $pdf->SetX(20);
        $pdf->Cell(0, 10 , utf8_decode($questionnaire->getCertificat()->getMedecin()) , 0, 0, 'L');
        $pdf->Ln(6);
        $pdf->SetX(20);
        $pdf->Cell(0, 10 , utf8_decode($questionnaire->getCertificat()->getSpecialite()->getNom()) , 0, 0, 'L');
        $pdf->Output('test.pdf', 'I');
        dd("ok");
        //$pdf = new Fpdf();
    }
}