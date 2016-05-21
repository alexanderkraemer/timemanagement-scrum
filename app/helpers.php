<?php
    /**
     * Created by PhpStorm.
     * User: Alexander
     * Date: 17/03/16
     * Time: 16:57
     */


    // My common functions
    function prepareArrayForFormBuilderSelect ( $arr, $value = 'name' )
    {
        $retArr    = [ ];
        $retArr[]  = '';
        $stringArr = explode ( '.', $value );
        foreach ( $arr as $a )
        {
            $resArr = [ ];
            foreach ( $stringArr as $string )
            {
                $resArr[] = $a->{$string};
            }
            $res              = implode ( ' - ', $resArr );
            $retArr[ $a->id ] = $res;
        }

        return $retArr;
    }

    function getErledigerToArr ( $arr )
    {
        $resArr = [];
        foreach ( $arr as $a)
        {
            $resArr[] = $a->user_id;
        }
        return $resArr;
    }

    function createTimestampFromDate ( $date )
    {
        if ( empty($date) OR $date == '' )
        {
            return '';
        }
        $months = [
            'Januar'    => '01',
            'Februar'   => '02',
            'März'      => '03',
            'April'     => '04',
            'Mai'       => '05',
            'Juni'      => '06',
            'Juli'      => '07',
            'August'    => '08',
            'September' => '09',
            'Oktober'   => '10',
            'November'  => '11',
            'Dezember'  => '12',
        ];

        $day   = explode ( '. ', $date )[ 0 ];
        $month = $months[ explode ( ' ', explode ( '. ', $date )[ 1 ] )[ 0 ] ];
        $year  = explode ( ' ', $date )[ 2 ];

        return $year . '-' . $month . '-' . $day;
    }

    /**
     * @param $url
     */
    function validateUrl ( $url )
    {
        if ( substr ( $url, 8 ) != 'http://' OR substr ( $url, 9 ) != 'https://' )
        {
            return 'http://' . $url;
        }
    }

    /**
     * @param $str
     */
    function deleteNull ( $str )
    {
        if ( $str == 0 )
        {
            return null;
        }
        else
        {
            return $str;
        }
    }

    function dateFromTimestamp ( $timestamp )
    {
        if ( $timestamp == null or $timestamp == '0000-00-00' )
        {
            return null;
        }
        else
        {
            $months = [
                '01' => 'Januar',
                '02' => 'Februar',
                '03' => 'März',
                '04' => 'April',
                '05' => 'Mai',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'August',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Dezember'
            ];

            return strftime ( "%d. " . $months[ explode ( '-', $timestamp )[ 1 ] ] . " %Y", strtotime ( $timestamp ) );
            //return strftime("%d. %B %Y", strtotime($timestamp));
        }
    }

    function timeFromTimestamp ( $timestamp )
    {
        if ( $timestamp == null or $timestamp == '00:00:00' )
        {
            return '00:00';
        }
        else
        {
            return strftime ( "%R", strtotime ( $timestamp ) );
            //return strftime("%d. %B %Y", strtotime($timestamp));
        }
    }