<?php

class TestLaetusPDF extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp() {
        parent::setUp();
    }
    
    
    public function testNumbers ()
    {

        $pdf = new App_PDF_Laetus();
        $pdf->setLaetusNumber(100);
        $this->assertTrue($pdf->drawBars());
    }
}
?>