<?php

namespace App\Repositories;

use App\Models\Configs;

/**
 * 此类为数据层基类，将公用的数据层操作封装好，通过继承类来操作
 */
abstract class BaseRepository
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * 创建数据
     * 2022-7-14
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model::create($data);
    }

    /**
     * 获取全部数据
     * 2022-7-14
     * @return mixed
     */
    public function all(){
        return $this->model::all();
    }
    public function select($name){
        return $this->model::select('name')->get();
    }
    /**
     * 修改数据
     * 2022-7-14
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        if($base=$this->model::find($id)){
            return $base->update($data);
        }
        return false;
//        return $this->model::find($id)->update($data);
    }

    /**
     * 判断一个字段值是否存在
     * 2022-7-14
     * @param $attribute
     * @param $value
     * @return mixed
     */
    public function exists($attribute, $value)
    {
        return $this->model::where($attribute, $value)->exists();
    }

    /**
     * 查询字段的第一条数据
     * 2022-7-14
     * @param $attribute
     * @param $value
     * @return mixed
     */
    public function findBy($attribute, $value)
    {
        return $this->model::where($attribute, $value)->first();
    }

    /**
     * 查询全部符合的字段
     * 2022-8-23
     * @param $attribute
     * @param $value
     * @return mixed
     */
    public function findByAll($attribute,$value){
        return $this->model::where($attribute,$value);
    }
    /**
     * 通过id获取数据
     * 2022-7-14
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->model::find($id);
    }

    /**
     * 通过主键删除数据
     * 2022-7-14
     * @param $ids
     * @return mixed
     */
    public function delete($ids){
        return $this->model->destroy($ids);
    }

    /**
     * 获取前端分页内容
     * 2022-7-20
     */
    public function frontPage()
    {
        return $this->model->paginate($this->frontPageNum());
    }
    /**
     * 获取前台搜索的分页内容
     * 2022-10-29
     */
    public function whereFrontPage($attribute,$operator,$value){
        if($operator==null){
            return $this->model::where($attribute,$value)->paginate($this->frontPageNum());
        }
        return $this->model::where($attribute,$operator,$value)->paginate($this->frontPageNum());
    }
    /**
     * 获取后端分页内容
     * 2022-7-20
     */
    public function backPage()
    {
        return $this->model->paginate($this->backPageNum());
    }

    /**
     * 获取后台搜索的分页内容
     * 2022-10-29
     */
    public function whereBackPage($attribute,$operator,$value){
        if($operator==null){
            return $this->model::where($attribute,$value)->paginate($this->backPageNum());
        }
        return $this->model::where($attribute,$operator,$value)->paginate($this->backPageNum());
    }
    /**
     * 返回前端每页内容数
     * 2022-7-20
     * @return mixed
     */
    public function frontPageNum(): mixed
    {
        return Configs::find(1)->front_page_num;
    }

    /**
     * 返回后端每页内容数
     * 2022-7-20
     * @return mixed
     */
    public function backPageNum(): mixed
    {
        return Configs::find(1)->back_page_num;
    }

    /**
     * 获取数据总数
     * @return mixed
     */
    public function getCount(): mixed
    {
        return $this->model->count();
    }
}
