<?php

namespace App\Repo;

class BaseRepo {

    public function ArrayPush(&$arr, $key, $value) {
        $arr[$key] = $value;
    }

    //http://stackoverflow.com/questions/3338413/deleting-last-array-value-php
    public function ArrayRemoveEnd(&$arr) {

        $end_item = end($arr);
        //dd($end_item);
        if (!empty($end_item)) {
            array_pop($arr);
        }
    }

    //http://stackoverflow.com/questions/369602/delete-an-element-from-an-array
    public function ArrayRemove(&$arr, $key) {

        unset($arr[$key]);
    }

    public function ArrayExists($arr, $key) {
        if (isset($arr[$key]) || array_key_exists($key, $arr))
            return true;
        else
            return false;
    }

    public function save(&$row, $all) {
        $columns = \DB::connection()->getSchemaBuilder()->getColumnListing($row->table_name());
        foreach ($all as $key => $value) {
            if (in_array($key, $columns)) {
                $row->$key = $value;
            }
        }
        try {
            $row->save();
            return "";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($row) {
        try {
            $row->delete();
            return "";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getSlug($title, $model) {
        $slug = \Str::slug($title);
        $slugCount = count($model->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'")->get());

        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }
    
    public function getByField($field,$value,$model)
    {
        return $model->where($field,$value)->first();
    }

}
