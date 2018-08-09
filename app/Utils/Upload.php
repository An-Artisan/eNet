<?php

namespace App\Utils;

class Upload
{
    /**
     * 上传单文件 files接受参数 $_FILES
     * @author StubbornGrass 2017-09-12
     * @param  [array] $files          [$_FILES]
     * @param  [string] $path          [上传的路径]
     * @return [boolean/string]        [成功返回地址，失败返回false]
     */
    public static function uploadImage($files,$path,$imagePath,$name){
        // 把当前上传图片的时间精确到秒作为文件名重新赋值给上传文件作为它的新的文件名
        $date = date('Y-m-dHis',time());
        // 以.来截取文件的后缀名
        $uptype = explode(".", $files[$name]["name"]);
        // 然后把当前时间加上后缀名就是该图片的新名称。
        $album_picture_name = $date.".".$uptype[1];
        // 给上传的头像重新命名
        $files["image"]["name"] = $album_picture_name;
        //定义上传文件存储位置
        $uploadPath = $path . $files[$name]["name"];
        $cover = $path .$files[$name]["name"];
        // 移动文件到自己建的文件夹下
        if(move_uploaded_file($files[$name]["tmp_name"], $uploadPath)){
            // 返回cover的地址
            return $imagePath . $files[$name]["name"];
        }
        return false;
    }
}
