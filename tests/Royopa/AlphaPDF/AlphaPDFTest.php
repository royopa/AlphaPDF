<?php
declare(strict_types=1);

namespace Royopa\AlphaPDF\Tests;

use Symfony\Component\Security\Core\User\User;
use PHPUnit\Framework\TestCase;
use Royopa\AlphaPDF\AlphaPDF;
use Royopa\AlphaPDF\WaterMark;
use Royopa\AlphaPDF\Fpdi;
use Symfony\Component\Filesystem\Filesystem;

class AlphaPDFTest extends TestCase
{
    protected $user;
    protected $sourceFile;
    protected $outputFile;

    public function testIsInstanceOfFpdi()
    {
        $alphaPdf = new AlphaPDF();
        $isInstance = false;
        if ($alphaPdf instanceof \setasign\Fpdi\Fpdi) {
            $isInstance = true;
        }
        $this->assertTrue($isInstance);

        if ($alphaPdf instanceof \Royopa\AlphaPDF\Fpdi) {
            $isInstance = true;
        }
        $this->assertTrue($isInstance);
    }

    public function testNumPagesWaterMark()
    {
        $waterMark = new WaterMark($this->sourceFile, $this->user);
        $this->assertEquals(
            20,
            $waterMark->getPdf()->getNumPages()
        );
    }

    public function testUserWaterMark()
    {
        $waterMark = new WaterMark($this->sourceFile, $this->user);

        $waterMark
            ->doWaterMark()
            ->Output('F', $this->outputFile)
        ;

        $waterMarkOutput = new WaterMark($this->outputFile, $this->user);

        $this->assertEquals(
            $waterMark->getPdf()->getNumPages(),
            $waterMarkOutput->getPdf()->getNumPages()
        );
    }

    public function setUp()
    {
        $this->user = new User('royopa', '123456');
        $this->sourceFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'CVM-Guia-01-FII.pdf';
        $this->outputFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'CVM-Guia-01-FII.output.pdf';
    }

    public function tearDown()
    {
        $fs = new Filesystem();
        $fs->remove($this->outputFile);
    }
}