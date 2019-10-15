<?php

namespace Hero;

class Hero{
    private $name = null;
    private $class = null;
    private $hp = null;
    private $power = null;
    private $exp = null;
    private $level = null;


    //The setters and getters for the Class attributes.
    public function setName($name){$this->name = $name;}
    public function getName(){return $this->name;}

    // public function setClass($class){$this->class = $class;}
    // public function getClass(){return $this->class;}

    // public function setHp($hp){$this->hp = $hp;}
    // public function getHp(){return $this->hp;}

    // public function setPower($power){$this->power = $power;}
    // public function getPower(){return $this->power;}

    // public function setExp($exp){$this->exp = $exp;}
    // public function getExp(){return $this->exp;}

    // public function setLevel($level){$this->level = $level;}
    // public function getLevel(){return $this->level;}

    public function createHero( $name, $class, $hp, $power, $exp){

        return "INSERT INTO hero VALUES (NULL, '$name', '$class', '$hp', '$power', '$exp', 1) ";
 
    }





}

?>