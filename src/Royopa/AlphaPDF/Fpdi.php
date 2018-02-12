<?php
/**
 * @author: Martin Hall-May <djmanmaster@gmx.net?subject=Transparency>
 */

namespace Royopa\AlphaPDF;

use setasign\Fpdi\Fpdi as setaSignFpdi;

class Fpdi extends setaSignFpdi
{
    public function GetK()
    {
        // Get k position
        return $this->k;
    }
}
