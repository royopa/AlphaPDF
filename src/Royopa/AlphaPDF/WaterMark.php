<?php

namespace Royopa\AlphaPDF;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * WaterMark
 *
 */
class WaterMark
{
    protected $pdf;
    protected $waterMarkBigText = "C O N F I D E N C I A L";
    protected $waterMarkSmallText = '';
    protected $numPages = 0;

    public function __construct($sourceFile)
    {
        $fs = new Filesystem();

        if (! $fs->exists($sourceFile)) {
            throw new FileNotFoundException('File not found.');
        }

        $this->pdf = new AlphaPDF();

        // set the source file and gets the number of pages
        $this->pdf->numPages = $this->pdf->setSourceFile($sourceFile);
    }

    public function getPdf()
    {
        return $this->pdf;
    }

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
            $this->pdf->SetTextColor(204, 0, 0);

            // set alpha to semi-transparency
            $this->pdf->SetAlpha(0.5);

            //posição na tela
            $this->pdf->SetX(-1);

            $this->pdf->SetLeftMargin(-78);

            //Rotaciona o texto "confidencial"
            $this->_rotate(55);

            $this->pdf->Write(0, $this->waterMarkBigText);

            $this->_rotate(0);//<-added

            //escreve os dados do usuário
            // now write some text above the imported page
            $this->pdf->SetFont('Arial', 'B', 13);

            //definir o tipo de texto
            $this->pdf->SetTextColor(204, 0, 0);

            // set alpha to semi-transparency
            $this->pdf->SetAlpha(0.5);

            //posição na tela
            $this->pdf->SetX(225);

            $this->pdf->SetLeftMargin(-35);

            // Rotate "confidential" text
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
    protected function _rotate($angle, $x=-1, $y=-1)
    {
        if ($x==-1) {
            $x=$this->pdf->getX();
        }
            
        if ($y==-1) {
            $y=$this->pdf->getY();
        }
            
        if ($this->pdf->getAngle() != 0) {
            $this->pdf->_out('Q');
        }
            
        $this->pdf->setAngle($angle);

        if ($angle != 0) {
            $angle *= M_PI/180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->pdf->getK();
            $cy = ($this->pdf->getH() - $y) * $this->pdf->getK();

            $this->pdf->_out(sprintf(
                'q %.5f %.5f %.5f %.5f %.2f %.2f cm 1 0 0 1 %.2f %.2f cm',
                $c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
        }
    }
}
