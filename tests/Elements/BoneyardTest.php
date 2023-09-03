<?php

namespace Fountain\Tests\Elements;

use Fountain\Elements\Boneyard;
use PHPUnit\Framework\TestCase;

class BoneyardTest extends TestCase
{
    /**
     * @var Boneyard
     */
    private $boneyard;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->boneyard = new Boneyard();
    }

    /**
     * @return void
     */
    public function testMatch(): void
    {
        $this->assertTrue($this->boneyard->match('/*'));
        $this->assertTrue($this->boneyard->match('*/'));
        $this->assertFalse($this->boneyard->match(''));
        $this->assertTrue($this->boneyard->match('/* a'));
        $this->assertTrue($this->boneyard->match('a */'));
    }

    /**
     * @return void
     */
    public function testSanitize(): void
    {
        $this->assertEquals('', $this->boneyard->sanitize('/*'));
        $this->assertEquals('', $this->boneyard->sanitize('*/'));
        $this->assertEquals('', $this->boneyard->sanitize(''));
        $this->assertEquals(' a', $this->boneyard->sanitize('/* a'));
        $this->assertEquals('a ', $this->boneyard->sanitize('a */'));
    }


}
