<?php

namespace ProcessBundle\Tests\Utils;

use PHPUnit\Framework\TestCase;
use ProcessBundle\Utils\PrepareXmlData;

class PrepareXmlDataTest extends TestCase
{
    public function testProcess() {
        $pd = new PrepareXmlData();
        $data = $pd->process(array());
        
        $this->assertEquals(array(), $data);
    }
}