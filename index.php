<?php

require "./vendor/autoload.php";


use League\Csv\Reader;

$csv = Reader::createFromPath('./arm.csv', 'r');
$csv->setHeaderOffset(0);

$header = $csv->getHeader(); //returns the CSV header record
$records = $csv->getRecords(); //returns all the CSV records as an Iterator object

$total = 0;

$addressString = $addressStringSub = $valString = $valStringSub = "";

foreach ($records as $label => $value)
{
    if (empty($value['address']) || empty($value['amount']))
    {
        continue;
    }
    $addressStringSub .=  "\"". $value["address"] . "\",";
    $valStringSub .=  "\"". $value["amount"] . "\",";

    $total  = getIntAdd($total, $value['amount']);

    echo print_r($value, true);
    echo "\n\n\n";
}
$addressStringSub = rtrim($addressStringSub, ",");
$addressString = "[" . $addressStringSub . "]";
echo $addressString;
echo "\n\n\n";

$valStringSub = rtrim($valStringSub, ",");
$valString = "[" . $valStringSub . "]";
echo $valString;
echo "\n\n\n";

echo "总数：". numToStr($total);
echo "\n\n\n";

function numToStr($num)
{
    $result = "";
    if (stripos($num, 'e') === false) {
        return $num;
    }
    while ($num > 0) {
        $v = $num - floor($num / 10) * 10;
        $num = floor($num / 10);
        $result = $v . $result;
    }
    return $result;
}

function getIntAdd($a, $b)
{
    $c = '';
    $bCount = strlen($b);
    $aCount = strlen($a);
    $count = max($bCount, $aCount);
    $aDiff = $count - $aCount;
    $bDiff = $count - $bCount;
    for ($i = $count - 1; $i >= 0; $i--) {
        $aVal = $count - $i <= $aCount ? intval($a[$i - $aDiff]) : 0;
        $bVal = $count - $i <= $bCount ? intval($b[$i - $bDiff]) : 0;
        $v = $aVal + $bVal;
        if (strlen($c) > 0 && strlen($c) >= $count - $i) {
            $c = ($v + intval($c[0])) . substr($c, 1, strlen($c) - 1);
        } else {
            $c = $v . $c . '';
        }
    }
    return $c;
}

echo "\n";
