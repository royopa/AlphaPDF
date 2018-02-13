<?php
declare(strict_types=1);

namespace Royopa\AlphaPDF\Tests;

use Symfony\Component\Security\Core\User\User;
use PHPUnit\Framework\TestCase;
use Royopa\AlphaPDF\AlphaPDF;
use Royopa\AlphaPDF\WaterMark;
use Royopa\AlphaPDF\Fpdi;

class AlphaPDFTest extends TestCase
{
    protected $user;
    protected $sourceFile;

    public function testIsInstanceOfFpdi()
    {
        $alphaPdf = new AlphaPDF();
        $isInstance = false;
        if ($alphaPdf instanceof \setasign\Fpdi\Fpdi) {
            $isInstance = true;
        }
        $this->assertTrue($isInstance);
    }

    public function testNumPagesWaterMark()
    {
        $waterMark = new WaterMark($this->sourceFile);
        $this->assertEquals(
            20,
            $waterMark->getPdf()->getNumPages()
        );
    }

    public function testUserWaterMark()
    {
        $waterMark = new WaterMark($this->sourceFile);
        $waterMark->doWaterMark($this->user);
    }

    public function setUp()
    {
        $user = new User('royopa', '123456');
        $this->user = $user;
        $this->sourceFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'CVM-Guia-01-FII.pdf';
    }
}