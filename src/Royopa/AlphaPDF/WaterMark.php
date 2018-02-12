<?php

namespace Royopa\AlphaPDF;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * WaterMark
 *
 */
class WaterMark
{
    public $pdf;

    public $wmText = "C O N F I D E N C I A L";

    /** $file and $newFile have to include the full path. */
    public function __construct($sourceFile)
    {
        //$this->pdf = new \FPDF_FPDI();

        $this->pdf = new AlphaPDF();

        // set the source file and gets the number of pages
        $this->pdf->numPages = $this->pdf->setSourceFile($sourceFile);
    }

    /** @todo Make the text nicer and add to all pages */
    public function doWaterMark(AdvancedUserInterface $user)
    {
        $pagecount = $this->pdf->numPages;

        for ($i = 1; $i <= $pagecount; $i++) {

            $this->pdf->addPage();//<- moved from outside loop
            $tplidx = $this->pdf->importPage($i);
            $this->pdf->useTemplate($tplidx, 10, 20, 200);

            // now write some text above the imported page
            $this->pdf->SetFont('Arial', 'B', 60);

            //definir o tipo de texto
            $this->pdf->SetTextColor(204,0,0);

            // set alpha to semi-transparency
            $this->pdf->SetAlpha(0.5);

            //posição na tela
            $this->pdf->SetX(-1);

            $this->pdf->SetLeftMargin(-78);

            //Rotaciona o texto "confidencial"
            $this->_rotate(55);

            $this->pdf->Write(0, $this->wmText);

            $this->_rotate(0);//<-added

            //escreve os dados do usuário
            // now write some text above the imported page
            $this->pdf->SetFont('Arial', 'B', 13);

            //definir o tipo de texto
            $this->pdf->SetTextColor(204,0,0);

            // set alpha to semi-transparency
            $this->pdf->SetAlpha(0.5);

            //posição na tela
            $this->pdf->SetX(225);

            $this->pdf->SetLeftMargin(-35);

            //Rotaciona o texto "confidencial"
            $this->_rotate(55);

            $now = new \DateTime('now');

            $this->pdf->Write(
                0,
                'Impresso por - ' .
                    $user->getUsername() .
                    ' em ' .
                    $now->format('d/m/Y H:i')
                );

            $this->_rotate(0);//<-added
        }

        return $this->pdf->Output();
    }

    /**
     * @param integer $angle
     */
    protected function _rotate($angle,$x=-1,$y=-1)
    {
        if($x==-1)
            $x=$this->pdf->x;
        if($y==-1)
            $y=$this->pdf->y;
        if($this->pdf->angle!=0)
            $this->pdf->_out('Q');
        $this->pdf->angle=$angle;

        if ($angle!=0) {
            $angle*=M_PI/180;
            $c=cos($angle);
            $s=sin($angle);
            $cx=$x*$this->pdf->k;
            $cy=($this->pdf->h-$y)*$this->pdf->k;

            $this->pdf->_out(sprintf(
                'q %.5f %.5f %.5f %.5f %.2f %.2f cm 1 0 0 1 %.2f %.2f cm',
                $c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
        }
    }
}
