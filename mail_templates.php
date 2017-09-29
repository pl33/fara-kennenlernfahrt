<?php

function mailTemplates()
{
    return array(
        "SignupAdmitted" => array(
            "de_subject" => "Anmeldung Kennenlernfahrt",
            "de" => "Hallo {{NAME}},

wir freuen uns über deine Anmeldung. Du stehst
nun auf der Teilnehmerliste.

Bitte bezahle {{PAYDEADLINE}} deinen
Teilnahmebeitrag in Höhe von {{FEE}} €, da
sonst dein Platz an einen anderen vergeben wird.
Überweisungen gehen:

Empfänger: {{RECEIPIENT}}
IBAN: {{IBAN}}
BIC: {{BIC}}

Schicke uns bitte eine Kopie der Bestätigung
der Überweisung per E-Mail, damit wir sie schneller
bearbeiten können.

Falls du eine Barzahlung gewählt hast, kannst
du den Beitrag bei uns im Büro zu den Sprechzeiten
begleichen.

Name: {{NAME}}
E-Mail: {{EMAIL}}
Telefon: {{PHONE}}
Fakultät: {{FACULTY}}
Gruppe: {{ROLE}}
Zahlungsart: {{PAYMETHOD}}
Anmerkungen:
{{REMARKS}}

Viele Grüße
Dein Fachschaftsrat

{{CONTACT}}


Automatisch generierte E-Mail
{{URI}}
Zeitstempel der Anmeldung: {{TIMESTAMP}}",
            "en_subject" => "Signup Freshman Tour",
            "en" => "Dear {{NAME}},

We're glad to receive your registration. You are
now on the participants list.

Please pay the fee of {{FEE}} €
{{PAYDEADLINE}}. Otherwise,
you might loose your admission.
Bank transfers go to

Receipient: {{RECEIPIENT}}
IBAN: {{IBAN}}
BIC: {{BIC}}

Please send us a copy of the payment receipt
via e-mail. That will speed up processing.

If you chose cash payment, you are welcome
to visit us during our office hours.

Name: {{NAME}}
E-mail: {{EMAIL}}
Phone: {{PHONE}}
Faculty: {{FACULTY}}
Group: {{ROLE}}
Payment method: {{PAYMETHOD}}
Remarks:
{{REMARKS}}

Kind regards
Your Student's Council

{{CONTACT}}


Automatically generated E-mail
{{URI}}
Signup timestamp: {{TIMESTAMP}}"
        ),
        "SignupWaiting" => array(
            "de_subject" => "Anmeldung Kennenlernfahrt",
            "de" => "Hallo {{NAME}},

wir freuen uns über deine Anmeldung. Leider sind die Plätze
bereits vergeben. Aber du stehst auf der Warteliste. Falls
ein Platz frei wird, melden wir uns bei dir. ;-)

Name: {{NAME}}
E-Mail: {{EMAIL}}
Telefon: {{PHONE}}
Fakultät: {{FACULTY}}
Gruppe: {{ROLE}}
Zahlungsart: {{PAYMETHOD}}
Anmerkungen:
{{REMARKS}}

Viele Grüße
Dein Fachschaftsrat

{{CONTACT}}


Automatisch generierte E-Mail
{{URI}}
Zeitstempel der Anmeldung: {{TIMESTAMP}}",
            "en_subject" => "Signup Freshman Tour",
            "en" => "Dear {{NAME}},

We're glad to receive your registration. Unfortunately,
we ran out of places. But you are currently on the
waiting list. If we have spare places, we will let you
know.

Name: {{NAME}}
E-mail: {{EMAIL}}
Phone: {{PHONE}}
Faculty: {{FACULTY}}
Group: {{ROLE}}
Payment method: {{PAYMETHOD}}
Remarks:
{{REMARKS}}

Kind regards
Your Student's Council

{{CONTACT}}


Automatically generated E-mail
{{URI}}
Signup timestamp: {{TIMESTAMP}}"
        ),
        "SignupMentor" => array(
            "de_subject" => "Anmeldung Kennenlernfahrt",
            "de" => "Hallo {{NAME}},

wir freuen uns über deine Anmeldung. Du stehst auf der Warteliste.
Falls wir Plätze haben, melden wir uns bei dir. ;-)

Name: {{NAME}}
E-Mail: {{EMAIL}}
Telefon: {{PHONE}}
Fakultät: {{FACULTY}}
Gruppe: {{ROLE}}
Zahlungsart: {{PAYMETHOD}}
Anmerkungen:
{{REMARKS}}

Viele Grüße
Dein Fachschaftsrat

{{CONTACT}}


Automatisch generierte E-Mail
{{URI}}
Zeitstempel der Anmeldung: {{TIMESTAMP}}",
            "en_subject" => "Signup Freshman Tour",
            "en" => "Dear {{NAME}},

We're glad to receive your registration. You are
currently on the waiting list. If we have spare
places, we will let you know.

Name: {{NAME}}
E-mail: {{EMAIL}}
Phone: {{PHONE}}
Faculty: {{FACULTY}}
Group: {{ROLE}}
Payment method: {{PAYMETHOD}}
Remarks:
{{REMARKS}}

Kind regards
Your Student's Council

{{CONTACT}}


Automatically generated E-mail
{{URI}}
Signup timestamp: {{TIMESTAMP}}"
        )
    );
}

