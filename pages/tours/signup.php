<?php

$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiYTQzNDI4MTM3MjI0OTIwOTY3ODkxZTIzMDU2NzkyMjI3N2ZmYTc3MTVlZGQxZWIwNDQ0NTI4NzAwZWYwOGQ3OTU5NDNlZDA2Yzk3MGQxODAiLCJpYXQiOjE2ODg5ODg4MzAuOTA3MDU3LCJuYmYiOjE2ODg5ODg4MzAuOTA3MDU5LCJleHAiOjQ4NDQ2NjI0MzAuOTAxNjQ1LCJzdWIiOiI1MjUyNDYiLCJzY29wZXMiOltdfQ.Zv1aqc9cIDcwlzEJeGglnlcc_9TaigXPXj0-8rPBhdflW6ckdydCefAupvhZmVknMKCJY8PdeT_FaRD1z7f7CjRYP7WDzs3DW-yByESvbpjlpquQcWYYQsZWN4UZN_fsYcTiLAzmeOlrqmw0VpnjgAOFD-8ne3IwoeVi7aHQvIbhZgU6_Lo-iJFzzSOstf0tCZnM_l5VtnwW04xJkhJL-53g9fLc80-Fq9jJ_UCMX_XfrSXlB2CnEL0049oNACPeXeubnWjVHtVyCtcFX9DfmH-mNOVKR60nUt41T2wfnNeaamAsS7b8MjQkH4HEUZKuyZvamVMPav-hjo3WLYRw8vOFKrt1Pd-jU_nr1KkEyJL6GtMfMmtYOFYZwV5sb7chW6hySMM2RdTJnlS9MLgmVEPoQ-L7LtnWa2z_EOuOXFccbSy_NCT7PnylRYapZ8EGOGALH0DIkdFYWgUF5W-qnqPmgAM3LpT2SUMpqogzcuvhcEwQ50ju7Sg6sHCTnrlhYPVV0tXI2Yeu3UeQ_zZM7-2A4Z-NCWDAbJQzL9_zqjj0fXhop4LMaUYvJ_AO4aoEzDRb-nz-S6nwjzqxSoH8YRUbXUk9VIU0JtUzIX1wcPFjRtt7Qi8nwFIa5JnjVHIdzpyBBOHkDxKBK2PPlAgeCixtYIz6hMrH_I2uvmnNaXc';


// first we check if they already exists:
$shouldBeAddedToMailerLite = true;
try{
    $subscriber_id = $_POST["user-email"];
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiYTQzNDI4MTM3MjI0OTIwOTY3ODkxZTIzMDU2NzkyMjI3N2ZmYTc3MTVlZGQxZWIwNDQ0NTI4NzAwZWYwOGQ3OTU5NDNlZDA2Yzk3MGQxODAiLCJpYXQiOjE2ODg5ODg4MzAuOTA3MDU3LCJuYmYiOjE2ODg5ODg4MzAuOTA3MDU5LCJleHAiOjQ4NDQ2NjI0MzAuOTAxNjQ1LCJzdWIiOiI1MjUyNDYiLCJzY29wZXMiOltdfQ.Zv1aqc9cIDcwlzEJeGglnlcc_9TaigXPXj0-8rPBhdflW6ckdydCefAupvhZmVknMKCJY8PdeT_FaRD1z7f7CjRYP7WDzs3DW-yByESvbpjlpquQcWYYQsZWN4UZN_fsYcTiLAzmeOlrqmw0VpnjgAOFD-8ne3IwoeVi7aHQvIbhZgU6_Lo-iJFzzSOstf0tCZnM_l5VtnwW04xJkhJL-53g9fLc80-Fq9jJ_UCMX_XfrSXlB2CnEL0049oNACPeXeubnWjVHtVyCtcFX9DfmH-mNOVKR60nUt41T2wfnNeaamAsS7b8MjQkH4HEUZKuyZvamVMPav-hjo3WLYRw8vOFKrt1Pd-jU_nr1KkEyJL6GtMfMmtYOFYZwV5sb7chW6hySMM2RdTJnlS9MLgmVEPoQ-L7LtnWa2z_EOuOXFccbSy_NCT7PnylRYapZ8EGOGALH0DIkdFYWgUF5W-qnqPmgAM3LpT2SUMpqogzcuvhcEwQ50ju7Sg6sHCTnrlhYPVV0tXI2Yeu3UeQ_zZM7-2A4Z-NCWDAbJQzL9_zqjj0fXhop4LMaUYvJ_AO4aoEzDRb-nz-S6nwjzqxSoH8YRUbXUk9VIU0JtUzIX1wcPFjRtt7Qi8nwFIa5JnjVHIdzpyBBOHkDxKBK2PPlAgeCixtYIz6hMrH_I2uvmnNaXc';
    $url = "https://connect.mailerlite.com/api/subscribers/".$subscriber_id;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', 'Authorization: Bearer ' . $token ));
    $result = curl_exec($ch);
    curl_close($ch);
  
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($httpcode === 200) {
        $mailerlitedata = json_decode($result)->data;
        if(!isset($mailerlitedata->status)) {
            // they didnt exist since before
        }
        $correctGroup = false;
        foreach($mailerlitedata->groups as $group){
            if($group->id === $_POST["group"] ) {
                $correctGroup = true;
            }
        }
        if($correctGroup) {
            $shouldBeAddedToMailerLite = false;
        }
    }
    
    
}
catch(Exception $e){
    $shouldBeAddedToMailerLite = true;
}
   

// then we add them
if(!$shouldBeAddedToMailerLite) {
    echo '{"result":"already_exists"}';
}
else {
    $email  = $_POST["user-email"] ?? "";
    $firstname  = $_POST["first-name"] ?? $_POST["user-name"] ?? "";
    $origin  = $_SERVER['HTTP_REFERER'] ?? "";
    $lastname  =$_POST["last-name"] ?? "";
    $url        = 'https://connect.mailerlite.com/api/subscribers';
    $datatosend = array(
    'email'  => $email,
    'fields' => array(
    'name'          => $firstname,
    'last_name'     => $lastname,
    "origin" => $origin
            
    ),
    'subscribed_at' => gmdate('Y-m-d h:i:s'),
    'opted_in_at'   => gmdate('Y-m-d h:i:s'),
    'optin_ip'      => $_SERVER['REMOTE_ADDR'] ?? '',
    'groups' => array(
    $_POST["group"] ?? ""
    
    ),
    );
    
    $postdata = json_encode($datatosend);
    try {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', 'Authorization: Bearer ' . $token ));
        $result = curl_exec($ch);
        curl_close($ch);
        header('Content-Type:application/json');
        $response = json_decode($result);
        if(isset($response->errors)) {
            throw new Exception("failed");
        };
        if($_POST["group"] === "95379137704756359") {
            echo '{"redirect":"confirm.html"}';
        }
        else {
            echo '{"result":"ok"}';
        }
        
    } catch ( Exception $e ) {
        header('Content-Type:application/json');
        http_response_code(400);
    }
    
}

