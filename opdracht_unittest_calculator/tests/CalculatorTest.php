<?php

use \PHPUnit\Framework\TestCase;

/* namespace VoorbeeldUnittest is gekoppeld aan de directory '/app' via composer.json
"autoload":{
        "psr-4":{
            "VoorbeeldUnittest\\": "app"
        }
*/
use \VoorbeeldUnittest\Calculator;

// de classname moet gelijk zijn aan de filenaam CalculatorTest.php
class CalculatorTest extends TestCase
{
    // Methods moeten starten met de naam test....
    public function testAdd()
     {
        // Of zonder use: $calculator = new \VoorbeeldUnittest\Calculator; 
        $calculator = new Calculator;

        // opdracht 1    
        $this->assertEquals("abc...xyz", $calculator->nummerDrie("abcdefghijklmnopqrstuvwxyz"));
        
        
        //opdracht 2 
        $this->assertEquals("Te Klein", $calculator->nummerCheck("a"));
        $this->assertEquals("abc...xyz", $calculator->nummerCheck("abcdefghijklmnopqrstuvwxyz"));
        $this->assertEquals("Het moet een string zijn", $calculator->nummerCheck(false));
        

        // opdracht 3

        $this->assertEquals("abc...xyz", $calculator->nummerDrie("abcdefghijklmnopqrstuvwxyz"));
        

    
        }
    }