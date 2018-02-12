<?php
declare(strict_types=1);

namespace Royopa\AlphaPDF\Tests;

use Symfony\Component\Security\Core\User\User;

use PHPUnit\Framework\TestCase;
use setasign\Fpdi\Fpdi;
use Royopa\AlphaPDF\AlphaPDF;

class AlphaPDFTest extends TestCase
{
    protected $user;

    public function testIsInstanceOfFpdi()
    {
        $alphaPdf = new AlphaPDF();
        $isInstance = false;
        if ($alphaPdf instanceof \setasign\Fpdi\Fpdi) {
            $isInstance = true;
        }
        $this->assertTrue($isInstance);
    }

    public function setUp()
    {
        $user = new User('royopa', '123456');
        $this->user = $user;
    }
}