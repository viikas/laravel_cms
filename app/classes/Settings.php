<?php

class Settings {
    /////////////////////////////////////
    //////// PAYPAL FUNCTIONS/////
    ///////////////////////////////////
    public static function GetCurrency()
    {
        $val=\Config::get('paypal.currency');
        if($val)
            return $val;
        else
            return 'USD';
    }

    /////////////////////////////////////
    //////// DATE AND TIME, TIMEZONE FUNCTIONS/////
    ///////////////////////////////////
   public static function GetDateFormat()
    {
        $val=\Config::get('timezone.dateformat');
        if($val)
            return $val;
        else
            return 'Y-m-d h:i:s a';
    }
    
    public static function GetTimeZone()
    {
        $val=\Config::get('timezone.timezone');
        if($val)
            return $val;
        else
            return 'Australia/Sydney';
    }
    
    /////////////////////////////////////
    //////// gets from global configurations/////
    ///////////////////////////////////
    
    public static function GetTaxRate()
    {
         $val=\Config::get('global.tax');
        if($val)
            return (float)$val;
        else
            return 0.00;
    }
    
    public static function GetSiteName()
    {
         $val=\Config::get('global.siteName');
        if($val)
            return $val;
        else
            return '';
    }
    
    public static function GetEmailFrom()
    {
         $val=\Config::get('global.emailFrom');
        if($val)
            return $val;
        else
            return '';
    }
    
    public static function GetEmailFromName()
    {
         $val=\Config::get('global.emailFromName');
        if($val)
            return $val;
        else
            return '';
    }
    public static function GetEmailTo()
    {
         $val=\Config::get('global.emailTo');
        if($val)
            return $val;
        else
            return '';
    }
    
    public static function GetEmailToName()
    {
         $val=\Config::get('global.emailToName');
        if($val)
            return $val;
        else
            return '';
    }
}
