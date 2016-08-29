<?php

class Helper {

    public static function GetHours($appendSelect, $selectText, $selectValue) {
        $values = array();
        $init = 0;
        if ($appendSelect) {
            $values[$selectValue] = $selectText;
            $init++;
        }
        for ($i = $init, $j = 1; $i <= (11 + $init), $j <= 12; $i++, $j++) {
            $values[$j] = Helper::GetPaddedNumber($j, 2, '0');
        }
        return $values;
    }

    public static function GetMinutes($appendSelect, $selectText, $selectValue, $interval) {
        $values = array();
        if ($appendSelect) {
            $values[(string) $selectValue] = $selectText;
        }
        for ($j = 0; $j < 60; $j = $j + $interval) {
            $values[Helper::GetPaddedNumber($j, 2, '0')] = Helper::GetPaddedNumber($j, 2, '0');
        }
        return $values;
    }

    private static function GetPaddedNumber($x, $length, $padWith) {
        $len = Strlen($x);
        if ($len < $length) {
            $offset = $length - $len;
            for ($i = 1; $i <= $offset; $i++)
                $x = $padWith . '' . $x;
        }
        return $x;
    }

    public static function ToTimeZoneDate($date, $fromDB, $double) {
        $date = Helper::ToDate($date, $fromDB);
        //$timezone=Settings::GetTimeZone();
        //$date->setTimeZone(new DateTimeZone($timezone));
        if (!$double)
            return $date->format(Settings::GetDateFormat());
        else {
            $d1 = $date->format('m/d/Y h:i:s a');
            $d2 = $date->format('l d, F');
            return $d1 . ' [' . $d2 . ']';
        }
    }

    public static function ToTimeZoneTime($date, $fromDB, $double) {
        $date = Helper::ToDate($date, $fromDB);
        //$timezone=Settings::GetTimeZone();
        //$date->setTimeZone(new DateTimeZone($timezone));
        if (!$double)
            return $date->format(Settings::GetDateFormat());
        else {
            $t1 = $date->format('H:i');
            $t2 = $date->format('h:i a');
            return $t1 . ' [' . $t2 . ']';
        }
    }

    public static function ToTimeZone($date, $fromDB) {
        $date = Helper::ToDate($date, $fromDB);
        $timezone = Settings::GetTimeZone();
        $date->setTimeZone(new DateTimeZone($timezone));
        return $date->format(Settings::GetDateFormat());
    }

    public static function ToDateString($date, $fromDB) {
        $date = Helper::ToDate($date, $fromDB);
        $format = Settings::GetDateFormat();
        return $date->format($format);
    }

    public static function ToTimeZoneString($date, $fromDB) {
        $date = Helper::ToTimeZone($date, $fromDB);
        $date = Helper::ToDate($date, $fromDB);
        $format = Settings::GetDateFormat();
        return $date->format($format);
    }

    public static function ToDate($date, $fromDB) {
        if (!($date instanceof \DateTime)) {
            $format = Settings::GetDateFormat();
            if ($fromDB)
                $format = 'Y-m-d H:i:s';
            $date = DateTime::createFromFormat($format, $date);
        }
        return $date;
    }

    public static function ToCurrentDateDB() {
        $format = Settings::GetDateFormat();
        $date = date($format);
        return $date;
    }

    public static function SetDefaultSelect($list, $value, $text) {
        return array($value => $text) + $list;
    }

    public static function GetRandomString($num_of_chars) {
        return substr(md5(microtime()), rand(0, 26), $num_of_chars);
    }

    public static function GetPercentage($old, $new) {
        return number_format(($old - $new) / $old * 100, 2);
    }

    public static function GetQuantities($min, $max) {

        for ($i = $min; $i <= $max; $i++) {
            $values[$i] = $i;
            ;
        }
        return $values;
    }

    public static function GetTextArrayByLineFeed($text) {
        return array_filter(explode("\n", $text), 'trim');
    }

    public static function GetCountries($append,$text,$value) {
        $list= array(
            'AF' => 'Afghanistan',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua And Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia And Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory',
            'BN' => 'Brunei',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Columbia',
            'KM' => 'Comoros',
            'CG' => 'Congo',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Cote D\'Ivorie (Ivory Coast)',
            'HR' => 'Croatia (Hrvatska)',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'CD' => 'Democratic Republic Of Congo (Zaire)',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'TP' => 'East Timor',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FK' => 'Falkland Islands (Malvinas)',
            'FO' => 'Faroe Islands',
            'FJ' => 'Fiji',
            'FI' => 'Finland',
            'FR' => 'France',
            'FX' => 'France, Metropolitan',
            'GF' => 'French Guinea',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard And McDonald Islands',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyzstan',
            'LA' => 'Laos',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macau',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar (Burma)',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'NL' => 'Netherlands',
            'AN' => 'Netherlands Antilles',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'KP' => 'North Korea',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russia',
            'RW' => 'Rwanda',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts And Nevis',
            'LC' => 'Saint Lucia',
            'PM' => 'Saint Pierre And Miquelon',
            'VC' => 'Saint Vincent And The Grenadines',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome And Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovak Republic',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia And South Sandwich Islands',
            'KR' => 'South Korea',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard And Jan Mayen',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syria',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad And Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks And Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'UK' => 'United Kingdom',
            'US' => 'United States',
            'UM' => 'United States Minor Outlying Islands',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VA' => 'Vatican City (Holy See)',
            'VE' => 'Venezuela',
            'VN' => 'Vietnam',
            'VG' => 'Virgin Islands (British)',
            'VI' => 'Virgin Islands (US)',
            'WF' => 'Wallis And Futuna Islands',
            'EH' => 'Western Sahara',
            'WS' => 'Western Samoa',
            'YE' => 'Yemen',
            'YU' => 'Yugoslavia',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe'
        );
        if($append)
            $list=\Helper::SetDefaultSelect ($list, $value, $text);
        return $list;
    }
    
    public static function GetTitles($append,$text,$value)
    {
        $list= array('Mr.'=>'Mr.',
            'Mrs.'=>'Mrs.',
            'Ms.'=>'Ms.',
            'Miss'=>'Miss');
        if($append)
            $list=\Helper::SetDefaultSelect ($list, $value, $text);
        return $list;
    }
    
    public static function Guid() {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45); // "-"
            $uuid = chr(123)// "{"
                    . substr($charid, 0, 8) . $hyphen
                    . substr($charid, 8, 4) . $hyphen
                    . substr($charid, 12, 4) . $hyphen
                    . substr($charid, 16, 4) . $hyphen
                    . substr($charid, 20, 12)
                    . chr(125); // "}"
            return trim($uuid, '{}');
        }
    }

}
