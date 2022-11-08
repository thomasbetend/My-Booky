<?php
function printLines(): void {

for($i=5; $i<=25; $i++) {
    echo "c'est la ligne " . $i . "<br>";
}
}

printLines();

function multiply(int $a): void {

    for($i=1; $i<=10; $i++) {
        echo $a . 'x' . $i . ' = '. $a * $i . "<br>";
    }
}

multiply(5);

$numbers = [
    1,
    9,
    6,
    7,
    5
];

function isPairImpair($array1) {
    
    $i=0;
    while($i < count($array1)){
        
        if($array1[$i]%2 === 0){
            echo $i . " est pair <br>";
        } else {
            echo $i . " est impair <br>";
        }

        $i++;
    }
}

isPairImpair($numbers);

function maxArray($array1) {

    $max = $array1[0];

    for($i = 0; $i < count($array1); $i++){
        
        if($max<$array1[$i]) $max=$array1[$i];
    }

    return $max;

}

echo maxArray($numbers);



