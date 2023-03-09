<?php
function calculateAge($dob)
{
    $interval = @date_diff(date_create($dob), date_create('today'));
    return $interval->format('%y');
}


?>