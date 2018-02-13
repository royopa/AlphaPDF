<?php
/**
 * @author: Martin Hall-May <djmanmaster@gmx.net?subject=Transparency>
 */

namespace Royopa\AlphaPDF;

use setasign\Fpdi\Fpdi as setaSignFpdi;

class Fpdi extends setaSignFpdi
{
    protected $numPages = 0;
    protected $angle;

    public function getK()
    {
        return $this->k;
    }

    public function getH()
    {
        return $this->h;
    }

    public function getX()
    {
        return $this->x;
    }

    public function getY()
    {
        return $this->y;
    }

    public function getNumPages()
    {
        return $this->numPages;
    }

    public function setNumPages($numPages)
    {
        $this->numPages = $numPages;
    }

    public function getAngle()
    {
        $this->angle;
    }

    public function setAngle($angle)
    {
        $this->angle = $angle;
    }
}
