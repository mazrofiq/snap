<?php
    $notificationHeader = getallheaders();
    $notificationBody = file_get_contents('php://input');
    $bodynotif = json_decode($notificationBody, true);
    
    $dateTime = gmdate("Y-m-d H:i:s");
    $isoDateTime = date(DATE_ISO8601, strtotime($dateTime)+60*60);
    $dateTimeFinal = substr($isoDateTime, 0, 20)."00:00";
    
    $inv = 'INV-' . time();

    $Body = array(
        'responseCode' => '2002400',
        'responseMessage' => 'Successful',
        'virtualAccountData' =>
        array(
            'partnerServiceId' => $bodynotif['partnerServiceId'],
            'customerNo' => $bodynotif['customerNo'],
            'virtualAccountNo' => $bodynotif['partnerServiceId'].$bodynotif['customerNo'],
            'virtualAccountName' => 'rafik',
            'virtualAccountEmail' => 'rafik@doku.com',
            'virtualAccountPhone' => '087805586273'
        ),
        'totalAmount' =>
        array(
            'value' => '10000.00',
            'currency' => 'IDR'
        ),
        'virtualAccountTrxType' =>'1',
        'expiredDate' =>$dateTimeFinal,
        'additionalInfo' =>
        array(
            'channel' => 'VIRTUAL_ACCOUNT_BANK_DANAMON',
            'virtualAccountConfig' => 
            array(
                'reusableStatus' => false
            )
        ),
        'inquiryStatus' => '00',
        'inquiryReason' =>
        array(
            'english' => 'Success',
            'indonesia' => 'Sukses'
        ),
        'inquiryRequestId' => $inv
    );
    
    
    header("X-TIMESTAMP:" . $notificationHeader['X-TIMESTAMP'] );
    header("X-SIGNATURE:" . $notificationHeader['X-SIGNATURE'] );
    header("X-PARTNER-ID:" . $notificationHeader['X-PARTNER-ID'] );
    header("X-EXTERNAL-ID:" . $notificationHeader['X-EXTERNAL-ID'] );
    echo json_encode($Body);
?>