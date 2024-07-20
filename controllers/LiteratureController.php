<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Literature;
use app\models\LiteratureSearch;
use app\models\Chapters;
use app\models\Graves;
use app\models\Messages;
use app\models\Likes;
use app\models\Bookmarks;

/**
 * LiteratureController implements the CRUD actions for Literature model.
 */
class LiteratureController extends Controller
{
    /**
     * @inheritDoc
     */
    

    /**
     * Lists all Literature models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LiteratureSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Literature model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $literature = Literature::findOne($id);

        if (!$literature) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $chapters = Chapters::find()->where(['literature_id' => $id])->orderBy('chapter_number')->all();

        return $this->render('view', [
            'model' => $literature,
            'chapters' => $chapters,
        ]);
    }

    /**
     * Creates a new Literature model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        // Create a new Literature model instance
        $model = new Literature();
    
        // Check if the user is logged in
        if (Yii::$app->user->isGuest) {
            // Redirect to login page if the user is not logged in
            return $this->redirect(['user/login']);
        }
    
        // Populate the model with the logged-in user's ID
        $model->author_id = Yii::$app->user->id;
    
        // Load form data into the model
        if ($model->load(Yii::$app->request->post())) {
            // Validate and save the model
            if ($model->save()) {
                // Redirect to the view page if save was successful
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
    
        // Render the create view
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    

    public function actionCreateChapter($literature_id)
    {
        $chapter = new Chapter();
        $chapter->literature_id = $literature_id;

        if ($chapter->load(Yii::$app->request->post()) && $chapter->save()) {
            return $this->redirect(['view-chapter', 'id' => $chapter->id]);
        }

        return $this->render('create-chapter', [
            'model' => $chapter,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Literature::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findChapterModel($id)
    {
        if (($model = Chapter::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Updates an existing Literature model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Literature model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionViewChapter($id)
    {
        $chapter = $this->findChapter($id);
        $literatureId = $chapter->literature_id;

        $prevChapter = Chapters::find()
            ->where(['<', 'id', $chapter->id])
            ->andWhere(['literature_id' => $literatureId])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        $nextChapter = Chapters::find()
            ->where(['>', 'id', $chapter->id])
            ->andWhere(['literature_id' => $literatureId])
            ->orderBy(['id' => SORT_ASC])
            ->one();

        return $this->render('view-chapter', [
            'chapter' => $chapter,
            'prevChapter' => $prevChapter,
            'nextChapter' => $nextChapter,
        ]);
    }

    /**
     * Finds the Chapter model based on its primary key value.
     * @param int $id ID
     * @return Chapters the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findChapter($id)
    {
        if (($model = Chapters::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Adds a like to a literature.
     * @param int $id Literature ID
     * @return \yii\web\Response
     */
    public function actionAddLike($id)
    {
        $literature = $this->findModel($id);

        $like = new Likes();
        $like->user_id = Yii::$app->user->id;
        $like->literature_id = $id;
        $like->save();

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Adds a bookmark to a literature.
     * @param int $id Literature ID
     * @return \yii\web\Response
     */
    public function actionAddBookmark($id)
    {
        $literature = $this->findModel($id);

        $bookmark = new Bookmarks();
        $bookmark->user_id = Yii::$app->user->id;
        $bookmark->literature_id = $id;
        $bookmark->save();

        return $this->redirect(['view', 'id' => $id]);
    }


    public function getChapters()
    {
        return $this->hasMany(Chapter::className(), ['literature_id' => 'id']);
    }
    

    
}
