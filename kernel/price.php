<?php

class Price
{
    static public function currentPrice($role)
    {
        if (time() < strtotime(\config()["PreBookEnd"]))
        {
            return \config()["Fee"][$role]["PreBooking"];
        }
        else
        {
            return \config()["Fee"][$role]["Regular"];
        }
    }
    
    static public function payDeadlineExceeded()
    {
        if (time() > strtotime(\config()["PayDeadline"]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

