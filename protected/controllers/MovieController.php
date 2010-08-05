<?php

class MovieController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to 'column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='application.views.layouts.column1';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
   * @TODO update removes movie attributes only
   * @TODO check if delete removes attributes also
	 */
	public function accessRules()
	{
		return array(
      array('allow',
        'actions' => array('view'),
        'users'   => array('*'),
      ),
			array('allow', // allow authenticated user
				'actions'=>array('index','tmdb','wishlist','wallpaper','inLibrary','onWishlist','rating'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user
				'actions'=>array('admin','import','export','delete','update'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
    $movie=$this->loadModel();
    $comment=$this->newComment($movie);

    $movie->views+=1;
    $movie->save();
    $this->render('view',array(
        'model'=>$movie,
        'comment'=>$comment,
    ));
	}
  /**
   * View Movie by TMDB-ID
   */
  public function actionTmdb()
  {
    $movie=$this->loadModel('tmdb');
    $comment=$this->newComment($movie);

    $movie->views+=1;
    $movie->save();
    $this->render('view',array(
        'model'=>$movie,
        'comment'=>$comment,
    ));
  }
  protected function newComment($movie)
  {
    $comment=new Comment;
    if(CHttpRequest::getPost('Comment'))
    {
      $comment->attributes=CHttpRequest::getPost('Comment');
      if($movie->addComment($comment))
        ;
    }
    return $comment;
  }

  /**
   * Import movies
   */
  public function actionImport()
  {
    if($movies=CHttpRequest::getPost('movies',false))
    {
      foreach(explode("\n",$movies) as $key=>$movie)
      {
        if(!ImportLog::model()->find('import_name=:movie',array(':movie'=>$movie)))
        {
          if(substr($movie, -2) == 02) continue; // 2nd part
          $search=SearchController::search(str_replace(array('-','01'),' ',$movie));
          $log=new ImportLog();
          $log->import_name=$movie;
          $log->search_id=$search->id;
          $log->save();
        }
      }
    }
    $this->render('import', array(
        'imported_movies'=>ImportLog::model()->findAll()
      ));
  }

  public function actionRating()
  {
    if(!$rating=MovieRating::model()->find('movie_id=:movie_id AND user_id=:user_id',
        array(':movie_id'=>CHttpRequest::getPost('id'),
              ':user_id'=>Yii::app()->user->id)))
    {
      $rating=new MovieRating();
      $rating->movie_id=CHttpRequest::getPost('id');
      $rating->user_id=Yii::app()->user->id;
    }
    $rating->value=CHttpRequest::getPost('rate');
    $rating->save();
    var_dump($rating);
  }

  /**
   * Export movie url-keys
   */
  public function actionExport()
  {
    $q="SELECT url_key FROM movie m JOIN user2movie um ON m.id=um.movie_id WHERE um.user_id=".Yii::app()->user->id." and um.in_library=1 ORDER BY url_key ASC";
    $models=Yii::app()->db->createCommand($q)->queryColumn();
    $this->layout=false;
    header('Content-type: application/text');
    header('Content-Disposition: attachment; filename="movies-export.txt"');
    $this->renderText(implode("\n", $models));
  }

  public function actionWallpaper()
  {
    $this->render('wallpaper', array(
        'images'=>MovieImages::model()->randomWallpaper()->byMovie(CHttpRequest::getQuery('url_key'))->findAll(),
      ));
  }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	private function relationUpdate($type='in_library')
	{
		if($id=CHttpRequest::getQuery('id'))
		{
      if(!$model=User2movie::model()->find('movie_id=:mid AND user_id=:uid',
        array(':mid'=>$id,':uid'=>Yii::app()->user->id)))
      {
        $model = new User2movie();
        $model->movie_id=$id;
        $model->user_id=Yii::app()->user->id;
      }
      $model->$type=($model->$type)?0:1;
      $model->save();
      $this->renderPartial('_relations',array('movie'=>$model->movie),false,true);
		}
    else
      $this->redirect(array('index'));
	}
  public function actionInLibrary() { $this->relationUpdate('in_library'); }
  public function actionOnWishlist() { $this->relationUpdate('on_wishlist'); }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Movie']))
		{
			$model->attributes=$_POST['Movie'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * List movies
   * @TODO combine index and wishlist action
   * @TODO filter by another user if set
	 */
	public function actionIndex()
	{
    $criteria=new CDbCriteria;
    $criteria->alias='m';
    $criteria->select='m.*';
    $criteria->join= 'JOIN user2movie um ON m.id=um.movie_id';
    $criteria->join.= ' JOIN user u ON um.user_id=u.id';
    $username=CHttpRequest::getQuery('username',Yii::app()->user->name);
    $criteria->condition='u.username=:username';
    $criteria->params[':username']=$username;
    $criteria->condition.=' AND um.in_library=1';
    $criteria->order='m.url_key ASC';
    $criteria->with=array('attributes', 'images'/*, 'comments'*/);
    if($filter=CHttpRequest::getQuery('filter'))
    {
      $criteria->condition.=' AND url_key LIKE :filter';
      $criteria->params[':filter']=$filter.'%';
    }

		$dataProvider=new CActiveDataProvider('Movie', array(
        'criteria'=>$criteria,
        'pagination'=>array(
            'pageSize'=>9,
        ),
      ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
  public function actionWishlist()
  {
    $criteria=new CDbCriteria;
    $criteria->alias='m';
    $criteria->select='m.*';
    $criteria->join= 'JOIN user2movie um ON m.id=um.movie_id';
    $criteria->join.= ' JOIN user u ON um.user_id=u.id';
    $username=CHttpRequest::getQuery('username',Yii::app()->user->name);
    $criteria->condition='u.username=:username';
    $criteria->params[':username']=$username;
    $criteria->condition.=' AND um.on_wishlist=1';
    $criteria->order='m.url_key ASC';
    $criteria->with=array('attributes', 'images'/*, 'comments'*/);
    if($filter=CHttpRequest::getQuery('filter'))
    {
      $criteria->condition.=' AND url_key LIKE :filter';
      $criteria->params[':filter']="$filter%";
    }

    $dataProvider=new CActiveDataProvider('Movie', array(
        'criteria'=>$criteria,
        'pagination'=>array(
            'pageSize'=>9,
        ),
      ));
    $this->render('index',array(
      'dataProvider'=>$dataProvider,
    ));
  }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Movie('search');
		if(isset($_GET['Movie']))
			$model->attributes=$_GET['Movie'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel($query = '')
	{
		if($this->_model===null)
		{
      if(isset($_GET['id']))
//         switch($query)
//         {
//           case 'tmdb':
            $this->_model=Movie::model()->with(array('attributes', 'images'))->find('tmdb_id=:id', array(':id' => $_GET['id']));
//             break;
//           default:
//             $this->_model=Movie::model()->with(array('attributes', 'images'))->findbyPk($_GET['id']);
//         }
      if(isset($_GET['url_key']))
        $this->_model=Movie::model()->with(array('attributes', 'images'))->find('url_key LIKE :url_key', array(':url_key' => $_GET['url_key']));
			if($this->_model===null)
          throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='movie-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
