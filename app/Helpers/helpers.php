<?php

use Morilog\Jalali\Jalalian;
//tabdil miladi be shamsi
function jalaliDate($date, $format = '%A, %d %B %Y ')
{
    return Jalalian::forge($date)->format($format);
}

function convertPersianToEnglish($number)
{
    $number = str_replace('۰', '0', $number);
    $number = str_replace('۱', '1', $number);
    $number = str_replace('۲', '2', $number);
    $number = str_replace('۳', '3', $number);
    $number = str_replace('۴', '4', $number);
    $number = str_replace('۵', '5', $number);
    $number = str_replace('۶', '6', $number);
    $number = str_replace('۷', '7', $number);
    $number = str_replace('۸', '8', $number);
    $number = str_replace('۹', '9', $number);

    return $number;
}


function convertArabicToEnglish($number)
{
    $number = str_replace('۰', '0', $number);
    $number = str_replace('۱', '1', $number);
    $number = str_replace('۲', '2', $number);
    $number = str_replace('۳', '3', $number);
    $number = str_replace('۴', '4', $number);
    $number = str_replace('۵', '5', $number);
    $number = str_replace('۶', '6', $number);
    $number = str_replace('۷', '7', $number);
    $number = str_replace('۸', '8', $number);
    $number = str_replace('۹', '9', $number);

    return $number;
}



function convertEnglishToPersian($number)
{
    $number = str_replace('0', '۰', $number);
    $number = str_replace('1', '۱', $number);
    $number = str_replace('2', '۲', $number);
    $number = str_replace('3', '۳', $number);
    $number = str_replace('4', '۴', $number);
    $number = str_replace('5', '۵', $number);
    $number = str_replace('6', '۶', $number);
    $number = str_replace('7', '۷', $number);
    $number = str_replace('8', '۸', $number);
    $number = str_replace('9', '۹', $number);

    return $number;
}



function priceFormat($price)
{
    //raqahm ashari nemikham
    //bain ashar / qarar bede
    //bain 3 add 3 add , bezar.
    // 100,000/00
    //va dar akhar tabdil persian to english
    $price = number_format($price, 0, '/', '،');
    $price = convertEnglishToPersian($price);
    return $price;
}

//baraye validate cod meli mitoni use koni


//function validateNationalCode($nationalCode)
//{
//    //nabayd fasele dashte bashe
//    $nationalCode = trim($nationalCode, ' .');
//    //bayd az arbi be english bashe
//    $nationalCode = convertArabicToEnglish($nationalCode);
//    //bayd az farsi be english bashe
//    $nationalCode = convertPersianToEnglish($nationalCode);
//    $bannedArray = ['0000000000', '1111111111', '2222222222', '3333333333', '4444444444', '5555555555', '6666666666', '7777777777', '8888888888', '9999999999'];
//
//    if(empty($nationalCode))
//    {
//        return false;
//    }
//    else if(count(str_split($nationalCode)) != 10)
//    {
//        return false;
//    }
//    else if(in_array($nationalCode, $bannedArray))
//    {
//        return false;
//    }
//    else{
//
//        $sum = 0;
//
//        for($i = 0; $i < 9; $i++)
//        {
//            // 1234567890
//            $sum += (int) $nationalCode[$i] * (10 - $i);
//        }
//
//        $divideRemaining = $sum % 11;
//
//        if($divideRemaining < 2)
//        {
//            $lastDigit = $divideRemaining;
//        }
//        else{
//            $lastDigit = 11 - ($divideRemaining);
//        }
//
//        if((int) $nationalCode[9] == $lastDigit)
//        {
//            return true;
//        }
//        else{
//            return false;
//        }
//
//    }
//}







