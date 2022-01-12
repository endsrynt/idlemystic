<?php

echo "\e[0;33m[!] Reff: \e[0m";

$reff =trim(fgets(STDIN));

start:

//RANDOM NAME

function nama()

	{	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "http://ninjaname.horseridersupply.com/indonesian_name.php");

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

	$ex = curl_exec($ch);

	// $rand = json_decode($rnd_get, true);

	preg_match_all('~(&bull; (.*?)<br/>&bull; )~', $ex, $name);

	return $name[2][mt_rand(0, 14) ];

	}

function angkarand($length)

{

    $str        = "";

    $characters = '1234567890';

    $max        = strlen($characters) - 1;

    for ($i = 0; $i < $length; $i++) {

        $rand = mt_rand(0, $max);

        $str .= $characters[$rand];

    }

    return $str;

}     

$nama = explode(" ", nama());

$nama1 = strtolower($nama[0]);

$nama2 = strtolower($nama[1]);

$rand = angkarand(3);

$namalengkap = "$nama1$nama2$rand";

$domain = "dikitin.com";

$email = "$namalengkap@$domain";

$reff = "edsrynt";

echo  "\e\33[32;1mRegistration $email\n";

echo "\e[0;33m[!]\e[0m STATUS    : ";

//REGIST   

$curl = curl_init();

curl_setopt_array($curl, array(

  CURLOPT_URL => 'https://www.idlemystic.io/api/auth/sendcode/email/?email='.$email,

  CURLOPT_RETURNTRANSFER => true,

  CURLOPT_ENCODING => '',

  CURLOPT_MAXREDIRS => 10,

  CURLOPT_TIMEOUT => 0,

  CURLOPT_FOLLOWLOCATION => true,

  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

  CURLOPT_CUSTOMREQUEST => 'GET',

  CURLOPT_HTTPHEADER => array(

    'Cookie: linkCode='.$reff

  ),

));

$response = curl_exec($curl);

curl_close($curl);

$result = json_decode($response);

$status1 = $result->message;

echo "\e[0;32m$status1\e[0m\n";

echo "\e[0;33m[!]\e[0m OTP       : ";

cek:

//CEK EMAIL

$curl = curl_init();

curl_setopt_array($curl, array(

CURLOPT_URL => 'generator.email/',

CURLOPT_RETURNTRANSFER => true,

CURLOPT_ENCODING => '',

CURLOPT_MAXREDIRS => 10,

CURLOPT_TIMEOUT => 0,

CURLOPT_FOLLOWLOCATION => true,

CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

CURLOPT_CUSTOMREQUEST => 'GET',

CURLOPT_HTTPHEADER => array(

          'cookie: surl='.$domain.'/'.$namalengkap

),

));

$response = curl_exec($curl);

curl_close($curl);

$title=explode("</title>",explode('<title>',$response)[1])[0];

if ($title=="[Idle Mystic] Please check your email code - Email Generator"){

    $otp=explode("\n",explode('<p>Your email verification code is：',$response)[1])[0];

    echo "\e[0;32m$otp\e[0m\n";

    echo "\e[0;33m[!]\e[0m STATUS    : ";

        $curl = curl_init();

    curl_setopt_array($curl, array(

    CURLOPT_URL => 'https://www.idlemystic.io/api/auth/register/',

    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_ENCODING => '',

    CURLOPT_MAXREDIRS => 10,

    CURLOPT_TIMEOUT => 0,

    CURLOPT_FOLLOWLOCATION => true,

    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

    CURLOPT_CUSTOMREQUEST => 'POST',

    CURLOPT_POSTFIELDS =>'{"email":"'.$email.'","code":"'.$otp.'","passwd":"Yesbisa123","invitercode":"'.$reff.'"}',

    CURLOPT_HTTPHEADER => array(

        'Content-Type: application/json'

    ),

    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $result = json_decode($response);

    $status2 = $result->message;

    $token = $result->body->token->access[0];

    echo "\e[0;32m$status2\e[0m\n";

    echo "\e[0;33m[!]\e[0m BANNED IP : ";

    

        //CEK BAN IP

        $curl = curl_init();

        curl_setopt_array($curl, array(

        CURLOPT_URL => 'https://www.idlemystic.io/api/admin/checkip/',

        CURLOPT_RETURNTRANSFER => true,

        CURLOPT_ENCODING => '',

        CURLOPT_MAXREDIRS => 10,

        CURLOPT_TIMEOUT => 0,

        CURLOPT_FOLLOWLOCATION => true,

        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

        CURLOPT_CUSTOMREQUEST => 'GET',

        CURLOPT_HTTPHEADER => array(

            'Cookie: Token='.$token

        ),

        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $status3=explode('}',explode('{"ban_ip":',$response)[1])[0];

        echo "\e[0;32m$status3\e[0m\n";

        if ($status3=="false"){

            $file = fopen("reff_im.txt","a");  

            fwrite($file,"".$email); 

            fwrite($file,"\n"); 

            fclose($file);  

            goto start;

        }else{

            echo  "\e\33[31;1mPLEASE CHANGE IP\n";

        }

}else{

    goto cek;

}
