<?php
namespace backend\models;


use yii\base\Model;

class SeachForm extends Model{
    //搜搜
    public $name;
    public $sn;
    public $start;
    public $end;

 public function rules()
 {
     return [
         [['name','sn','start','end'],'safe']
     ];
 }

}