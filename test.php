<?php

declare(strict_types=1);

echo time() . "<br>";

echo date("Y-m-d H-i-s", time()) . "<br>";


class Dog 
{
    private string $name;
    private DateTime $birthDate;
    private string $type;
    
    public function __construct(string $name, DateTime $birthDate, string $type)
    {
        $this->name = $name;
        $this->birthDate = $birthDate;
        $this->type = $type;
    }

    private function getAge() : string 
    {
        $diff = $this->birthDate->diff(new DateTime());

        return $diff->format('%y');
    }

    public function getInfo() : string 
    {
        return "Nom : " . $this->name . ", Age : " . $this->getAge() . ", Race : " . $this->type;
    }
}

$dog1 = new Dog('milou', DateTime::createFromFormat("Y-m-d", "2020-01-01"), 'terrier');
$dog2 = new Dog('bill', DateTime::createFromFormat("Y-m-d", "2017-08-01"), 'cocker');
$dog3 = new Dog('bibi', DateTime::createFromFormat("Y-m-d", "2015-05-11"), 'dalmatien');

$dogs = [
    $dog1, $dog2, $dog3,
];

function infoDogs(array $array) : void {
    foreach($array as $value){
        echo $value->getInfo() . "<br>";
    }
}


infoDogs($dogs);


class Rect 
{
    protected float $side1;
    protected float $side2;

    public function __construct(float $side1, float $side2)
    {
        $this->side1 = $side1;
        $this->side2 = $side2;
    }

    public function getPerimeter() : float 
    {
        return 2*($this->side1 + $this->side2);
    }

    public function getArea() : float 
    {
        return $this->side1 * $this->side2;
    }
}

class Square extends Rect
{
    public function __construct(float $side)
    {
        parent::__construct($side, $side);
    }

}

$carre1 = new Square(2);
$carre2 = new Square(1.8);

echo $carre1->getPerimeter() . "<br>";
echo $carre2->getArea();


class Stock 
{
    private array $articles;

    public function __construct(int $nbArticles)
    {
        $this->nbArticles = $nbArticles;
    }

    public function addArticle($newArticle) 
    {
        if(in_array($newArticle->getReference(), $articles)){
            $articles[
                $newArticle->getReference();
            ] = $newArticle;
        }
    }

    public function getArticleByReference($ref) 
    {
        foreach($articles as $article){
            if ($article->getReference() === $ref) {
                return $article;
            } else {
                throw (new Exception $e)
            }
    }
}

class Article
{
    private int $reference;
    private string $name;
    private float $price;

    public function __construct(int $reference, string $name, float $price)
    {
        $this->reference = $reference;
        $this->name = $name;
        $this->price = $price;
    }

    public function getReference()
    {

    }

}