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