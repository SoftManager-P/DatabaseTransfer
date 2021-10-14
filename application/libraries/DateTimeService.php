<?php

// App::uses('AppController', 'Controller');
// App::uses('IDateTime', 'Interface');

require_once APPPATH . 'libraries/IDateTime.php';
date_default_timezone_set('UTC');

class DateTimeService implements IDateTime {

    // Func: Converts a UTC date/time to the account's timezone and returns a formatted string
    //       If no date/time is supplied, returns the current date/time per the account's timezone
    // Rtrn: A formatted string the same as what the date() function would return
    // Auth: JMR
    public function toLocal($format, $utcDT = false) {
        // Create object
        if($utcDT) {
            if(gettype($utcDT) == 'string') {
                $utcDT = strtotime($utcDT);
            } elseif($utcDT == null) {
                $utcDT = time(); // Now in UTC
            } // Else it's already a time value
            $utcDT = gmdate('Y-m-d H:i:s', $utcDT); // Expand to full date/time
            $dateTime = new DateTime($utcDT, new DateTimeZone('UTC'));
        } else {
            $dateTime = new DateTime(); // Use UTC
        }
        // Check which period the date is in
        $utcSwitch = new DateTime(SystemSettings::UTC_SWITCH_DATE);
        if($dateTime >= $utcSwitch) {
            $dateTime->setTimezone(new DateTimeZone($_SESSION['TZ']['zone']));
        }

        return $dateTime->format($format);
    }

    // Func: Converts a date/time to UTC based on the account's timezone and returns a formatted string
    //       If no date/time is supplied, returns the current UTC date/time
    // Rtrn: A formatted string the same as what the date() function would return
    // Auth: JMR
    public function toUtc($format, $localDT = false) {
        // Create object
        if($localDT) {
            if(gettype($localDT) == 'string') {
                $localDT = strtotime($localDT);
            }
            $localDT = gmdate('Y-m-d H:i:s', $localDT); // Expand to full date/time
            $dateTime = new DateTime($localDT, new DateTimeZone($_SESSION['TZ']['zone']));
            // Check which period the date is in
            $utcSwitch = new DateTime(SystemSettings::UTC_SWITCH_DATE);
            if($dateTime >= $utcSwitch) {
                $dateTime->setTimezone(new DateTimeZone('UTC'));
            }
        } else {
            $dateTime = new DateTime(); // Use UTC
        }

        return $dateTime->format($format);
    }

}
