<?php

class TwitterPost
{
  public static function send($msg)
  {
    return self::sendCallback($msg);
  }


  private static function sendCallback($msg)
  {
    if(YII_DEBUG) return true;

    if(strlen($msg)>140)
      $msg=substr($msg,0,137).'...';

    if(!extension_loaded('curl'))
      throw new Exception('Extension curl not loaded!');
    $ch = curl_init(Yii::app()->params['twitter']['api']);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'status='.$msg);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD,
      Yii::app()->params['twitter']['user'].":".Yii::app()->params['twitter']['password']);
    $results = curl_exec($ch);
    $headers = curl_getinfo($ch);
    $error_number = curl_errno($ch);
    $error_message = curl_error($ch);
    curl_close($ch);

    return $results;
  }
}
