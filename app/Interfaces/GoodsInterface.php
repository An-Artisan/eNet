<?php

/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/19
 * Time: 10:18
 */

namespace App\Interfaces;

use Illuminate\Http\Request;

interface GoodsInterface
{

    public function index(Request $request);

    public function store(Request $request);

    public function update(Request $request,$id);

    public function  destroy(Request $request,$id);

    public function  show(Request $request,$ids);

    public function upload(Request $request);

    public function export(Request $request);

    public function import(Request $request);

    public function goodsList(Request $request);

    public function oftenBrowse(Request $request);

    public function getOftenBrowse(Request $request);

    public function searchGoods(Request $request);

    public function getHistorySearch(Request $request);

    public function getHotSearch(Request $request);

    public function deleteHistorySearch(Request $request);
}
