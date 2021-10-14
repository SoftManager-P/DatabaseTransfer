<?php

interface IDateTime {

    public function toLocal($format, $utcDateTime);
    public function toUtc($format, $utcDateTime);

}
