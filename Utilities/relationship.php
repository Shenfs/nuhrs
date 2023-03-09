<?php 
$relationships = [
    "Mother",
    "Father",
    "Son",
    "Daughter-in-law",
    "Sister",
    "Brother",
    "Aunt",
    "Uncle",
    "Niece",
    "Nephew",
    "Cousin",
    "Grandmother",
    "Grandfather",
    "Granddaughter",
    "Grandson",
    "Stepsister",
    "Stepbrother",
    "Stepmother",
    "Stepfather",
    "Stepdaughter",
    "Stepson",
    "Sister-in-law",
    "Brother-in-law",
    "Mother-in-law",
    "Father-in-law",
    "Daughter-in-law",
    "Son-in-law"
];

for($i = 0; $i < count($relationships); $i++){
    echo "<option value=".$relationships[$i].">".$relationships[$i] ."</option>";
}
?>