<?php

abstract class Animal 
{
    public function __construct(protected string $name)
    {
    }

    public function getName(): string 
    {
        return $this->name;
    }
}

Interface Screamer 
{
    public function getScream(): string;
}

class Cat extends Animal implements Screamer 
{
    public static $nameClass = 'chat';

    public function getScream(): string
    {
        return "Miaouuuuh !";
    }
}

class Dog extends Animal implements Screamer 
{
    public static $nameClass = 'chien';

    public function getScream(): string
    {
        return "Wouaf Wouaf !";
    }
}

class Rabbit extends Animal
{
    public static $nameClass = 'lapin';
}

class Snake extends Animal
{
    public static $nameClass = 'serpent';
}

$filou = new Cat('filou');
$medor = new Dog('medor');
$panpan = new Rabbit('panpan');
$kar = new Snake('kar');


function makeScream($animal){
/*     if(method_exists($animal,'getScream'))
 */    if($animal instanceof Screamer){
        echo ucfirst($animal->getName()) . " peut crier car c'est un " . $animal::$nameClass . " et il fait " . $animal->getScream() . "<br>";
    } else {
        echo ucfirst($animal->getName()) . " ne peut pas crier car c'est un " . $animal::$nameClass . "... <br>";
    }
}

makeScream($panpan);
makeScream($kar);
makeScream($filou);