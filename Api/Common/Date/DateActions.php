<?php

namespace Api\Common\Date;

class DateActions {

    /**
     *  @return string
     */
    public static function timestampConvertToStringDate(int $timestamp, string $format = 'Y-m-d H:i:s', string $UTC = 'America/Sao_Paulo'){
        return (new \DateTime())->setTimeZone(new \DateTimeZone($UTC))->setTimestamp($timestamp)->format($format);
    }


    /**
     *  @return DateTime
     */
    public static function timestampConvertToDateTime(int $timestamp, string $format = 'Y-m-d H:i:s', string $UTC = 'America/Sao_Paulo'){
        return (new \DateTime())->setTimeZone(new \DateTimeZone($UTC))->setTimestamp($timestamp);
    }
}
