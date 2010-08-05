<?php

class SearchController extends Controller
{
	public function actionIndex()
	{
		$this->render('index',
        array(
          'callback'=>SearchController::search(CHttpRequest::getQuery('text'))
        )
      );
	}

  public static function search($query)
  {
    try {
      $query=strtolower($query);
      $callback = SearchLog::model()->find('query LIKE :query', array(':query' => trim(strtolower($query))));

      if(empty($callback)) {
        $callback = new SearchLog();
        $callback->query= $query;
        $callback->save();
      }
      return $callback;
    } catch(Exception $e) {
      throw new CHttpException(500,$e->getMessage());
    }
  }

  public function accessRules()
  {
    return array(
      array('allow',
        'actions' => array('index'),
        'users'   => array('@'),
      ),
      array('deny',
        'users' => array('*'),
      ),
    );
  }
}
