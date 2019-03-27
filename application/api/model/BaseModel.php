<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2019/1/3
 * Time: 10:40
 */

namespace app\api\model;


use think\Model;

class BaseModel extends Model
{
    protected static $page = 1;
    protected static $pageSize = 10;
    protected static $where = [];
    protected static $fields = '*';
    protected static $with = [];
    protected static $order = [];
    protected static $group = '';
    protected static $limit = '';

    // 设置完整图片路径 ($value, $data)
    protected function prefixImgUrl($value)
    {
        return config('program.img_prefix').$value;
    }


    /**
     * 获取数据
     * @param array $wheres 条件[page=>'', pageSize='', where1=>'', where2=>'']
     * @param array $whereFields  条件查询的字段
     * @param string $field
     * @param bool $isPage  是否分页
     * @return array
     */
    protected static function getDatas($wheres = [], $whereFields = [], $field = '*', $isPage = true)
    {
        self::splicingWhere($wheres, $whereFields);
        self::splicingPage($wheres);
        self::splicingFields($field);
        self::splicingWith($wheres);
        self::splicingOrder($wheres);
        self::splicingGroup($wheres);
        $splicing = self::dealChain();
        $data = self::outData($splicing, $isPage);
        return $data;
    }


    // 输出
    public static function outData($splicing, $isPage)
    {
        if($isPage){
            $data = $splicing->paginate(self::$pageSize, false, ['page'=>self::$page])
                ->toArray();
        } else {
            $data = $splicing->select()->toArray();
        }
        return $data;
    }

    // 处理页码,每页数量
    public static function splicingPage($wheres = [])
    {
        if(isset($wheres['page'])){
            self::$page = $wheres['page'];
        }
        if(isset($wheres['pageSize'])){
            self::$pageSize = $wheres['pageSize'];
        }
    }

    // 拼接where条件
    protected static function splicingWhere($wheres = [], $whereFields = [])
    {
        $where = [];
        if(!empty($whereFields)){
            if(!empty($wheres)){
                foreach ($whereFields as $k=>$v){
                    if(isset($wheres[$v[0]])){
                        if($v[1] == 'like'){
                            $v[2] = '%'.$wheres[$v[0]].'%';
                        } else {
                            $v[2] = $wheres[$v[0]];
                        }
                        $where[] = $v;
                    }
                }
            }
        }
        self::$where = $where;
    }

    // 处理 field 字段
    protected static function splicingFields($field = '*')
    {
        self::$fields = $field;
    }

    // 处理 with 关联
    protected static function splicingWith($wheres = [])
    {
        if(isset($wheres['with'])){
            self::$with = $wheres['with'];
        }
    }

    // 处理 order 排序
    protected static function splicingOrder($wheres = [])
    {
        if(isset($wheres['order'])){
            self::$order = $wheres['order'];
        }
    }

    // 处理 group 分组
    protected static function splicingGroup($wheres = [])
    {
        if(isset($wheres['group'])){
            self::$group = $wheres['group'];
        }
    }

    // 处理 链式操作
    protected static function  dealChain()
    {
        $splicing = self::where(self::$where);
        if(self::$fields){
            $splicing->field(self::$fields);
        }
        if(self::$with){
            $splicing->with(self::$with);
        }
        if(self::$group){
            $splicing->group(self::$group);
        }
        if(self::$order){
            $splicing->order(self::$order);
        }
        return $splicing;
    }

}