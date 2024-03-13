<?php
namespace VoorbeeldUnittest;
class Calculator
{
   public function nummerDrie($str){
      return  substr($str, 0,4)."...". substr($str, -3);
   }

   public function nummerCheck($str){

      if(gettype($str) !== "string"){
         return "Het moet een string zijn";
         
      }elseif(strlen($str) <= 5){
         return "Te Klein";
      }
             return substr($str, 0,3)."...". substr($str, -3);
       
   }

}