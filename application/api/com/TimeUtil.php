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
        if(strrpos($format, 'd') !== false){
            $day = floor( $sec / 86400);
            $sec = $sec % 86400;
            $format = str_replace('d', $day,    $format);
        }

        if(strrpos($format, 'h') !== false){
            $hour = floor($sec / 3600);
            $sec = $sec % 3600;
            $format = str_replace('h', $hour,   $format);
        }

        if(strrpos($format, 'm') !== false){
            $minute = floor($sec / 60);
            $sec = $sec % 60;
            $format = str_replace('m', $minute, $format);
        }

        if(strrpos($format, 's') !== false){
            $format = str_replace('s', $sec, $format);
        }

        return $format;
    }


    /**
     * 获取某年某月的第一天和最后一天时间戳(日期)
     * @param string $month 日期(默认当前时间)
     * @param string $flag date返回日期, time返回时间戳
     * @return array
     */
    public function firstAndLastTimestamp($month = '', $flag = 'time')
    {
        // $month = '2018-12';
        if($month != ''){
            $str = strtotime($month);
            if(empty($str)){
                return false;
            }
            $firstDayDate = date('Y-m-01 00:00:00', $str);
            $lastDayDate = date('Y-m-t 23:59:59', $str);
        } else {
            $firstDayDate = date('Y-m-01 00:00:00');
            $lastDayDate = date('Y-m-t 23:59:59');
        }
        if($flag == 'time'){
            $firstDayTime = strtotime($firstDayDate);
            $lastDayTime = strtotime($lastDayDate);
            $data = [
                $firstDayTime,
                $lastDayTime
            ];
        } else {
            $data = [
                $firstDayDate,
                $lastDayDate
            ];
        }
        return $data;
    }


    /**
     * 获取两个月份的开始和结束时间戳
     * @param $month1
     * @param $month2
     * @param string $flag
     * @return array|bool
     */
    function firstAndLastTwoMonth($month1, $month2, $flag = 'time')
    {
        $a = strtotime($month1);
        $b = strtotime($month2);
        if(!$a || !$b){
            return false;
        }
        if($a < $b){
            $max = $b;
            $min = $a;
        } else {
            $max = $a;
            $min = $b;
        }
        if($flag == 'time'){
            $firstDayTime= strtotime(date('Y-m-01 00:00:00', $min));
            $lastDayTime = strtotime(date('Y-m-t 23:59:59', $max));
            $data = [$firstDayTime, $lastDayTime];
        } else {
            $firstDayDate = date('Y-m-01 00:00:00', $min);
            $lastDayDate = date('Y-m-t 23:59:59', $max);
            $data = [$firstDayDate, $lastDayDate];
        }
        return $data;
    }


    /**
     * 某时间的开始时间和结束时间 年/月/日
     * @param string $time 时间(默认当前时间戳)
     * @param string $flag time输出时间戳/date输出日期
     * @return array
     */
    public function changeTime($time = '', $flag = 'time')
    {
        if($time){
            if($time){
                $str = strtotime($time);
            } else {
                $str = time();
                $time = date('Y-m-d');
            }
            if(empty($str)){
                return false;
            }
            $timeArr = explode('-', $time);
            foreach ($timeArr as $v){
                if($v <= 0){
                    return false;
                }
            }
            $timeCount = count($timeArr);
            if($timeCount == 3){
                // 年月日
                $startDate =date('Y-m-d 00:00:00', $str);
                $endDate  = date('Y-m-d 23:59:59', $str);
                $data = [$startDate, $endDate];
            } else if($timeCount == 2){
                // 年月
                $startDate =date('Y-m-01 00:00:00', $str);
                $endDate  = date('Y-m-t 23:59:59', $str);
                $data = [$startDate, $endDate];
            } else if($timeCount == 1){
                // 年
                $startDate =date('Y-01-01 00:00:00', $str);
                $endDate  = date('Y-01-t 23:59:59', $str);
                $data = [$startDate, $endDate];
            } else {
                return false;
            }

            if($flag == 'time'){
                $startTime = strtotime($startDate);
                $endTime = strtotime($endDate);
                $data = [$startTime, $endTime];
            }
            return $data;
        } else {
            return false;
        }
    }


    // 获取某时间点的最后一天
    public function monthLastDay($month)
    {
        $lastDay = date('t', strtotime($month));
        return $lastDay;
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