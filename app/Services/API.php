<?php

/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/19
 * Time: 20:40
 */

namespace App\Services;

use App\Utils\Format;

use Illuminate\Database\Eloquent\Model;

class API
{
    protected $class;

    public static function getModel($id, $class = null)
    {
        return $class::find($id);
    }

    public static function getCount($key, $value, $class = null)
    {
        return $class::where($key, $value)->get()->count();
    }

    public static function createModel($param, $class = null)
    {
        $model = new $class;
        $model = self::formatModel($model, $param);
        $resp = $model->save();

        if ($resp) {
            return $model;
        }
        return false;
    }

    public static function updateModel($id,$param, $class = null)
    {
        $model = $class::find($id);
        $model = self::formatModel($model, $param);
        $resp = $model->update();

        if ($resp) {
            return $model;
        }
        return false;
    }

    public static function deteleModel($id, $class = null)
    {
        $model = $class::find($id);
        $resp = $model->delete();
        if ($resp) {
            return $model;
        }
        return false;
    }

    public static function insert($param, $class = null)
    {
        $resp = $class::insert($param);
        return $resp;
    }

    // Non-Static Function
    public function getLimit($key, $value, $limit = 10, $offset = 0, $class = null)
    {
        if ($class == null) {
            $class = $this->class;
        }

        return $class::where($key, $value)
            ->offset($offset)->take($limit)->get();
    }

    public function create($param, $class = null)
    {
        if ($class == null) {
            $class = $this->class;
        }

        $model = new $class;
        $model = self::formatModel($model, $param);
        $resp = $model->save();

        if ($resp) {
            return $model;
        }
        return false;
    }

    public function update($param, $class = null, $nonCreate = false)
    {
        if ($class == null) {
            $class = $this->class;
        }

        $model = $class::find($param['id']);
        if (isset($model) && $model) {
            $model = Format::formatModel($model, $param);
            $resp = $model->update();
            if ($resp) {
                return $model;
            }
        } elseif ($nonCreate) {
            $model = new $class;
            $model = self::formatModel($model, $param);
            $resp = $model->save();
            if ($resp) {
                return $model;
            }
        }

        return false;
    }

    public function delete($ids, $class = null)
    {
        if ($class == null) {
            $class = $this->class;
        }

        return $class::destroy($ids);
    }

    public static function formatModel(Model $model, $param)
    {
        foreach (array_keys($param) as $key) {
            if ($key == 'id') {
                continue;
            }
            if ($model->getAttribute($key) == $param[$key]) {
                continue;
            }

            $value = $param[$key];
            $model->setAttribute($key, $value);
        }
        return $model;
    }

    public static function getAtributeForId($id,$key,$class) {
        $model = $class::find($id);
        if ($model)
            return $model->$key;
        else return false;

    }
}
