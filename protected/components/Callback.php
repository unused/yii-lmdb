<?php

class Callback
{
  public static function searchMovie($name)
  {
    return self::sendCallback($name, 'Movie.search');
  }

  public static function getMovieInfo($tmdbid)
  {
    if(!is_numeric($tmdbid))
      throw new Exception ('No TMDB-ID given!');
    return self::sendCallback($tmdbid, 'Movie.getInfo');
  }

  /// @TODO abort on error
  private static function sendCallback($query, $request)
  {
    $api='http://api.themoviedb.org/2.1';
    $key=Yii::app()->params['tmdb']['key'];
    $type='json';
    $lang='de';

    if(!extension_loaded('curl'))
      throw new Exception('Extension curl not loaded!');

    $url = "$api/$request/$lang/$type/$key/".urlencode($query);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    $results = curl_exec($ch);
    $headers = curl_getinfo($ch);
    $error_number = curl_errno($ch);
    $error_message = curl_error($ch);
    curl_close($ch);

    return $results;
  }

  public static function decode($value)
  {
    return CJSON::decode($value);
  }
  public static function encode($value)
  {
    return CJSON::encode($value);
  }
}