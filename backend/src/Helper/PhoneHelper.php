<?php


namespace App\Helper;


class PhoneHelper
{
    public function normalizePhone($phone)
    {
        return preg_replace('/\D/', '', $phone);
    }
}
