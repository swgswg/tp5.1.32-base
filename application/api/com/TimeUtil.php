<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2019/3/27
 * Time: 10:38
 */

namespace app\api\com;


class TimeUtil extends BaseCom
{
    /**
     * 把秒数转化为天时分秒表示
     * @param $sec
     * @param string $format
     * @return mixed|string
     */
    public function secondChange($sec, $format = 'd天h小时m分钟s秒')
    {
        if(strpos($format, 'd') !== false){
            $day = floor( $sec / 86400);
            $sec = $sec % 86400;
            $format = str_replace('d', $day, $format);
        }

        if(strpos($format, 'h') !== false){
            $hour = floor($sec / 3600);
            $sec = $sec % 3600;
            $format = str_replace('h', $hour, $format);
        }

        if(strpos($format, 'm') !== false){
            $minute = floor($sec / 60);
            $sec = $sec % 60;
            $format = str_replace('m', $minute, $format);
        }

        if(strpos($format, 's') !== false){
            $format = str_replace('s', $sec, $format);
        }

        return $format;
    }



    /**
     * 时间段内 开始-结束 时间戳/日期
     * @param $startTime
     * @param $endTime
     * @param string $flag
     * @return array|bool
     */
    function periodOfTime($startTime = '', $endTime = '', $flag = 'time')
    {
        $a = strtotime($startTime);
        $b = strtotime($endTime);
        if($a === false){
            $a = time();
            $startTime = date('Y-m-d');
        }
        if($b === false){
            $b = time();
            $endTime = date('Y-m-d');
        }
        if($a < $b){
            $max = $endTime;
            $min = $startTime;
        } else {
            $max = $startTime;
            $min = $endTime;
        }
        $start= $this -> timeStartEnd($min, $flag);
        $end  = $this -> timeStartEnd($max, $flag);
        $data = [
            'start_time' => $start['start_time'],
            'end_time'   => $end['end_time']
        ];
        return $data;
    }


    /**
     * 某时间的开始时间和结束时间 年/月/日
     * @param string $time 时间(默认当前时间戳)
     * @param string $flag time输出时间戳/date输出日期
     * @return array
     */
    public function timeStartEnd($time = '', $flag = 'time')
    {
        $str = strtotime($time);
        if($str === false ){
            $str = time();
            $time = date('Y-m-d');
        }
        $timeArr = explode('-', $time);
        $timeCount = count($timeArr);
        switch ($timeCount) {
            case 1:
                // 年
                $startDate =date('Y-01-01 00:00:00', $str);
                $endDate  = date('Y-12-t 23:59:59', $str);
                $data = ['start' => $startDate, 'end' => $endDate];
                break;
            case 2:
                // 年月
                $startDate =date('Y-m-01 00:00:00', $str);
                $endDate  = date('Y-m-t 23:59:59', $str);
                $data = ['start' => $startDate, 'end' => $endDate];
                break;
            default:
                // 年月日
                $startDate =date('Y-m-d 00:00:00', $str);
                $endDate  = date('Y-m-d 23:59:59', $str);
                $data = ['start' => $startDate, 'end' => $endDate];
                break;
        }
        if($flag == 'time'){
            $startTime = strtotime($startDate);
            $endTime = strtotime($endDate);
            $data = ['start' => $startTime, 'end' => $endTime];
        }
        return $data;

    }


    // 获取某时间点的最后一天
    public function monthLastDay($month)
    {
        $lastDay = date('t', strtotime($month));
        return $lastDay;
    }


    /**
     * 返回今日开始和结束的时间戳
     *
     * @return array
     */
    public function today()
    {
        return [
            mktime( 0, 0, 0, date( 'm' ), date( 'd' ), date( 'Y' ) ),
            mktime( 23, 59, 59, date( 'm' ), date( 'd' ), date( 'Y' ) ),
        ];
    }
    /**
     * 返回昨日开始和结束的时间戳
     *
     * @return array
     */
    public function yesterday()
    {
        $yesterday = date( 'd' ) - 1;
        return [
            mktime( 0, 0, 0, date( 'm' ), $yesterday, date( 'Y' ) ),
            mktime( 23, 59, 59, date( 'm' ), $yesterday, date( 'Y' ) ),
        ];
    }
    /**
     * 返回本周开始和结束的时间戳
     *
     * @return array
     */
    public function week()
    {
        $timestamp = time();
        return [
            strtotime( date( 'Y-m-d', strtotime( "+0 week Monday", $timestamp ) ) ),
            strtotime( date( 'Y-m-d', strtotime( "+0 week Sunday", $timestamp ) ) ) + 24 * 3600 - 1,
        ];
    }
    /**
     * 返回上周开始和结束的时间戳
     *
     * @return array
     */
    public function lastWeek()
    {
        $timestamp = time();
        return [
            strtotime( date( 'Y-m-d', strtotime( "last week Monday", $timestamp ) ) ),
            strtotime( date( 'Y-m-d', strtotime( "last week Sunday", $timestamp ) ) ) + 24 * 3600 - 1,
        ];
    }
    /**
     * 返回本月开始和结束的时间戳
     *
     * @return array
     */
    public function month()
    {
        return [
            mktime( 0, 0, 0, date( 'm' ), 1, date( 'Y' ) ),
            mktime( 23, 59, 59, date( 'm' ), date( 't' ), date( 'Y' ) ),
        ];
    }
    /**
     * 返回上个月开始和结束的时间戳
     *
     * @return array
     */
    public function lastMonth()
    {
        $begin = mktime( 0, 0, 0, date( 'm' ) - 1, 1, date( 'Y' ) );
        $end   = mktime( 23, 59, 59, date( 'm' ) - 1, date( 't', $begin ), date( 'Y' ) );
        return [$begin, $end];
    }
    /**
     * 返回今年开始和结束的时间戳
     *
     * @return array
     */
    public function year()
    {
        return [
            mktime( 0, 0, 0, 1, 1, date( 'Y' ) ),
            mktime( 23, 59, 59, 12, 31, date( 'Y' ) ),
        ];
    }
    /**
     * 返回去年开始和结束的时间戳
     *
     * @return array
     */
    public function lastYear()
    {
        $year = date( 'Y' ) - 1;
        return [
            mktime( 0, 0, 0, 1, 1, $year ),
            mktime( 23, 59, 59, 12, 31, $year ),
        ];
    }

    /**
     * 获取几天前零点到现在/昨日结束的时间戳
     *
     * @param int  $day 天数
     * @param bool $now 返回现在或者昨天结束时间戳
     * @return array
     */
    public function dayToNow( $day = 1, $now = true )
    {
        $end = time();
        if( !$now ){
            list( $foo, $end ) = $this->yesterday();
        }
        return [
            mktime( 0, 0, 0, date( 'm' ), date( 'd' ) - $day, date( 'Y' ) ),
            $end,
        ];
    }
    /**
     * 返回几天前的时间戳
     *
     * @param int $day
     * @return int
     */
    public function daysAgo( $day = 1 )
    {
        $nowTime = time();
        return $nowTime - $this->daysToSecond( $day );
    }


    /**
     * 返回几天后的时间戳
     *
     * @param int $day
     * @return int
     */
    public function daysAfter( $day = 1 )
    {
        $nowTime = time();
        return $nowTime + $this->daysToSecond( $day );
    }


    /**
     * 天数转换成秒数
     *
     * @param int $day
     * @return int
     */
    public function daysToSecond( $day = 1 )
    {
        return $day * 86400;
    }


    /**
     * 周数转换成秒数
     *
     * @param int $week
     * @return int
     */
    public function weekToSecond( $week = 1 )
    {
        return $this->daysToSecond() * 7 * $week;
    }


    /**
     * 获取毫秒级别的时间戳
     */
    function getMillisecond()
    {
        //获取毫秒的时间戳
        $time = explode ( " ", microtime () );
        $time = $time[1] . ($time[0] * 1000);
        $time2 = explode( ".", $time );
        $time = $time2[0];
        return $time;
    }
}