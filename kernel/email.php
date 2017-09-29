<?php


function generateMail($template, $participant, $lang="de")
{
    $text = $template[$lang];
    
    $paymethod = array(
        "de" => array(
            "bank" => "Überweisung",
            "cash" => "Barzahlung"
        ),
        "en" => array(
            "bank" => "Bank transfer",
            "cash" => "Cash"
        )
    );
    
    $role = array(
        "de" => array(
            "freshman" => "Ersti",
            "mentor" => "Mentor",
            "fara" => "FaRa"
        ),
        "en" => array(
            "freshman" => "Freshman",
            "mentor" => "Mentor",
            "fara" => "FaRa"
        )
    );
    
    $payhint = array(
        "de" => array(
            true => "schnellstmöglich",
            false => "bis zum ".date('d.m.Y', strtotime(\config()["PayDeadline"]))
        ),
        "en" => array(
            true => "as fast as possible",
            false => "until ".date('d.m.Y', strtotime(\config()["PayDeadline"]))
        )
    );
    
    $text = str_replace("{{NAME}}", $participant->name, $text);
    $text = str_replace("{{EMAIL}}", $participant->email, $text);
    $text = str_replace("{{PHONE}}", $participant->phone, $text);
    $text = str_replace("{{FACULTY}}", $participant->faculty, $text);
    $text = str_replace("{{RECEIPIENT}}", \config()["Bank"][$participant->faculty]["Receipient"], $text);
    $text = str_replace("{{IBAN}}", \config()["Bank"][$participant->faculty]["IBAN"], $text);
    $text = str_replace("{{BIC}}", \config()["Bank"][$participant->faculty]["BIC"], $text);
    $text = str_replace("{{ROLE}}", $role[$lang][$participant->role], $text);
    $text = str_replace("{{PAYMETHOD}}", $paymethod[$lang][$participant->paymethod], $text);
    $text = str_replace("{{REMARKS}}", $participant->remarks, $text);
    $text = str_replace("{{TIMESTAMP}}", $participant->signup_timestamp, $text);
    $text = str_replace("{{FEE}}", $participant->fee, $text);
    $text = str_replace("{{PAYDEADLINE}}", $payhint[$lang][\Price::payDeadlineExceeded()], $text);
    $text = str_replace("{{CONTACT}}", \config()["EMail"][$participant->faculty]["Address"], $text);
    $text = str_replace("{{URI}}", $_SERVER['HTTP_REFERER'], $text);
    
    return $text;
}

function sendMail($template, $participant, $lang="de")
{
    $message = generateMail($template, $participant, $lang);
    
    $to = $participant->name." <".$participant->email.">";
    $from = \config()["EMail"][$participant->faculty]["Name"]." <".\config()["EMail"][$participant->faculty]["Address"].">";
    $subject = $template[$lang."_subject"];
    
    $bcc = "";
    if (\config()["EMailSignupBCC"] != "")
    {
        $bcc = "BCC: ".\config()["EMailSignupBCC"];
    }
    
    mail($to, $subject, $message, "From: ".$from."\r\nContent-Type: text/plain;charset=utf-8\r\n".$bcc);
}

