<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2018/12/11
 * Time: 11:40
 */

namespace app\api\service;


use app\api\com\Singleton;
use app\api\com\StringUtil;
use app\api\controller\Upload;
use app\api\validate\ExcelValidate;
use app\lib\exception\ExcelException;
use PhpOffice\ExcelService;

class Excel
{
    use Singleton;

    private function __construct()
    {}


    /**
     * 获取表格数据
     * @param array $head
     * @param string $filePath
     * @param string $ext
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function getExcelData($head = [], $filePath = '', $ext = '')
    {
        // $head = ['用户手机'=>'mobile'];
        $excelData = ExcelService::getExcelData($head, $filePath, $ext);
        return $excelData;
    }


    /**
     * 把数据保存到表格
     * @param array $heads  表格头
     * @param array $keys   需要的数据字段
     * @param array $data   要保存的数据 二维数组
     * @param string $fileName 文件名称
     * @param string $ext   文件后缀 格式:excel2003 = xls, excel2007 = xlsx
     * @param string $title  sheet的标题
     * @return string  返回路径+文件名
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function dataToExcel($heads = [], $keys = [], $data = [], $ext = 'xlsx', $fileName = '', $title = 'swg')
    {
        // 没有文件名使用随机名
        if(empty($fileName)){
            $fileName = StringUtil::getInstance()->randFileName();
        }
        return ExcelService::dataToExcel($heads, $keys, $data, $ext, $fileName, $title);
        //return $this->exportExcel($spreadsheet, 'xls', '登陆日志');
    }


    /**
     * 下载文件
     * @param $filename 文件名(全路径)
     */
    public function exportExcel($filename)
    {
//        if ($format == 'xls') {
//            //输出Excel03版本
//            header('Content-Type:application/vnd.ms-excel');
//        } elseif ($format == 'xlsx') {
//            //输出07Excel版本
//            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//        }
        //输出名称
        header('Content-Disposition:attachment;filename=' . basename($filename) );
        header('content-length:'. filesize($filename));
        //禁止缓存
        header('Cache-Control: max-age=0');
        readfile($filename);
//        unlink($filePath);

//        // Redirect output to a client’s web browser (Xlsx)
//        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//        header('Content-Disposition: attachment;filename="01simple.xlsx"');
//        header('Cache-Control: max-age=0');
//        // If you're serving to IE 9, then the following may be needed
//        header('Cache-Control: max-age=1');
//
//        // If you're serving to IE over SSL, then the following may be needed
//        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
//        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
//        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
//        header('Pragma: public'); // HTTP/1.0
    }

}