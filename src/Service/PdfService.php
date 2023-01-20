<?php

namespace App\Service;

use Fpdf\Fpdf;
use Symfony\Contracts\Translation\TranslatorInterface;

class PdfService
{
    private $translatorInterface;
    public function __construct(TranslatorInterface $translatorInterface)
    {
        $this->translatorInterface = $translatorInterface;
    }
    /**
     * Entete de nos pdf
     *
     * @return Fpdf
     */
    public function headerPage(){

        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 8);
        $widthCMS = $pdf->GetStringWidth($this->translatorInterface->trans('cms'));
        $pdf->SetFont('Times', 'B', 8);
        $widthRepublique = $pdf->GetStringWidth($this->translatorInterface->trans('republique'));
        $pdf->SetX(10+($widthCMS-$widthRepublique)/2);
        
        $pdf->Cell(0, 10 , utf8_decode($this->translatorInterface->trans('republique')), 0, 0, 'L');
        $pdf->SetFont('Times', '', 7);
        $pdf->Cell(0, 10 , utf8_decode($this->translatorInterface->trans('chrono')),0, 0, 'R');
        $pdf->Ln(6);
        
        $pdf->SetFont('Times', 'I', 7);
        $widthDevise = $pdf->GetStringWidth($this->translatorInterface->trans('devise'));
        $indent = ( - $pdf->GetStringWidth($this->translatorInterface->trans('devise')))/2;
        $pdf->SetX($pdf->GetX()+($widthCMS-$widthDevise)/2);
        $pdf->Cell(0, 10 , utf8_decode($this->translatorInterface->trans('devise')),0, 0, 'L');
        $pdf->Ln(8);
        $pdf->SetFont('Times', '', 8);
        $widthMin1 = $pdf->GetStringWidth($this->translatorInterface->trans('min1'));
        $pdf->setX(10+($widthCMS-$widthMin1)/2);
        $pdf->Cell(0, 10 , utf8_decode($this->translatorInterface->trans('min1')),0, 0, 'L');
        $pdf->Ln(6);
        $pdf->SetFont('Times', '', 8);
        
        $pdf->setX(10+($widthCMS-$widthMin1)/2);
        
        $indent = ($pdf->GetStringWidth($this->translatorInterface->trans('min1')) - $pdf->GetStringWidth($this->translatorInterface->trans('min2')))/2;
        $pdf->SetX($pdf->GetX()+$indent);
        $widthMin2 = $pdf->GetStringWidth($this->translatorInterface->trans('min2'));
        $pdf->setX(10+($widthCMS-$widthMin2)/2);
        $pdf->Cell(0, 10 , utf8_decode($this->translatorInterface->trans('min2')),0, 0, 'L');
        $pdf->Ln(8);
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(0, 10 , utf8_decode($this->translatorInterface->trans('cms')),0, 0, 'L');
        $pdf->Ln(6);
        $pdf->SetFont('Times', 'B', 8);
        $indent = ($widthCMS - $pdf->GetStringWidth($this->translatorInterface->trans('cs')))/2;
        $pdf->SetX($pdf->GetX()+$indent);
        $widthCS = $pdf->GetStringWidth($this->translatorInterface->trans('cc'));
        $pdf->Cell(0, 10 , utf8_decode($this->translatorInterface->trans('cs')),0, 0, 'L');
        // $pdf->setY(-31);
        // $pdf->SetFont('Times', '', 8);
        // $pdf->Cell(0, 10 , utf8_decode($this->translatorInterface->trans('footer')),0, 0, 'C');
        return $pdf;

    }
}