<?php

function config()
{
    return array(
        "URI" => "",
        "FaRas" => array("ABC", "XYZ"),
        "EMail" => array(
            "ABC" => array("Address" => "info@abc.tld", "Name" => "Fachschaftsrat ABC"),
            "XYZ" => array("Address" => "info@xyz.tld", "Name" => "Fachschaftsrat XYZ")
        ),
        "EMailSignupBCC" => "Person <manager@abc.tld>, Person <manager@xyz.tld>",
        "Bank" => array(
            "ABC" => array("Receipient" => "Fachschaftsrat ABC", "IBAN" => "DExx xxxx xxxx xxxx xxxx", "BIC" => "xxxxDExxxxx"),
            "XYZ" => array("Receipient" => "Fachschaftsrat ABC", "IBAN" => "DExx xxxx xxxx xxxx xxxx", "BIC" => "xxxxDExxxxx")
        ),
        "FreshmanQuota" => array("ABC" => 11, "XYZ" => 11),
        "DB" => array(
            "DSN" => "sqlite:test.db",
            "Username" => "",
            "Password" => "",
            "Options" => array()
        ),
        "SignupStart" => "2017-09-28 12:00:00",
        "SignupEnd" => "2017-10-10 12:00:00",
        "PreBookEnd" => "2017-09-30 13:00:00",
        "Fee" => array(
            "freshman" => array("PreBooking" => 29.00, "Regular" => 39.00),
            "mentor" => array("PreBooking" => 39.00, "Regular" => 39.00),
            "fara" => array("PreBooking" => 39.00, "Regular" => 39.00),
        ),
        "FeeDescription" => array(
            "de" => "Fr&uuml;hbucher (Erstis): 29 €<br />Sonst: 39 €",
            "en" => "Pre-booking (freshman): 29 €<br />Else: 39 €"
        ),
        "PayDeadline" => "2017-09-15 13:00:00",
        "Impress" => "http://www.abc.tld/Impressum.html"
    );
}

?>

