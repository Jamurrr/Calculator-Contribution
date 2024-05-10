<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $depositAmount = $_POST["deposit-amount"];
    $depositTerm = $_POST["deposit-term"];
    $replenishment = $_POST["deposit-replenishment"];
    $replenishmentAmount = $_POST["replenishment-amount"];
    
    $depositTerm = $depositTerm * 12;
    $result = calculateDeposit($depositAmount, $depositTerm, $replenishment, $replenishmentAmount);

    echo json_encode($result);
}

function calculateDeposit($depositAmount, $depositTerm, $replenishment, $replenishmentAmount) {
    $percent = 0.10; 
    $daysInYear = 365; 

    if ($replenishment == "yes") {
        $result = calculateWithReplenishment($depositAmount, $depositTerm, $replenishmentAmount, $percent, $daysInYear);
    } 
    else {
        $result = calculateWithoutReplenishment($depositAmount, $depositTerm, $percent, $daysInYear);
    }
    return $result;
}

function calculateWithoutReplenishment($depositAmount, $depositTerm, $percent, $daysInYear) {
    $sum = $depositAmount;
    for ($i = 1; $i <= $depositTerm; $i++) {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date("n"), date("Y"));
        $sum = $sum + ($sum * $daysInMonth * $percent / $daysInYear);
    }
    return $sum;
}

function calculateWithReplenishment($depositAmount, $depositTerm, $replenishmentAmount, $percent, $daysInYear) {
    $sum = $depositAmount;
    for ($i = 1; $i <= $depositTerm; $i++) {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date("n"), date("Y"));
        $sum = $sum + (($sum + $replenishmentAmount) * $daysInMonth * $percent / $daysInYear);
    }
    return $sum;
}

?>
