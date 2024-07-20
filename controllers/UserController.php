<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use app\models\User;
use app\models\LoginForm;
use app\models\RegistrationForm;
use app\models\ContactForm;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionAccount()
    {
        $user = Yii::$app->user->identity;
        $user->scenario = 'default'; 

        if ($user->load(Yii::$app->request->post())) {
            if ($user->validate()) {
                if ($user->save()) {
                    Yii::$app->session->setFlash('success', 'Профиль обновлен успешно.');
                } else {
                    Yii::$app->session->setFlash('error', 'Не удалось обновить профиль.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка валидации.');
            }
        }


        if (Yii::$app->request->isPost) {
            $user->avatarFile = UploadedFile::getInstance($user, 'avatarFile');
            if ($user->avatarOption === 'file' && $user->avatarFile) {
                if ($user->upload()) {
                    if ($user->save(false)) { 
                        Yii::$app->session->setFlash('success', 'Аватар обновлен успешно.');
                    } else {
                        Yii::$app->session->setFlash('error', 'Не удалось обновить аватар.');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка при загрузке файла.');
                }
            } elseif ($user->avatarOption === 'url') {
                if ($user->save(false)) {
                    Yii::$app->session->setFlash('success', 'Аватар обновлен успешно.');
                } else {
                    Yii::$app->session->setFlash('error', 'Не удалось обновить аватар.');
                }
            }
        }

        return $this->render('account', [
            'user' => $user,
        ]);
    }

    public function actionProfile()
    {
        $user = Yii::$app->user->identity;

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            if ($user->load(Yii::$app->request->post()) && $user->save()) {
                return $this->asJson([
                    'success' => true,
                    'content' => $this->renderPartial('profile', ['user' => $user])
                ]);
            } else {
                return $this->asJson([
                    'success' => false,
                    'errors' => ActiveForm::validate($user)
                ]);
            }
        }

        return $this->render('profile', [
            'user' => $user,
        ]);
    }

    public function actionAvatar()
    {
        $user = Yii::$app->user->identity;
        return $this->renderPartial('avatar', [
            'user' => $user,
        ]);
    }

    public function actionSecurity()
    {
        $user = Yii::$app->user->identity;
        $auth = Yii::$app->authManager;
        
        $roles = $auth->getRolesByUser($user->id);
        $roleNames = array_keys($roles);

        return $this->render('security', [
            'user' => $user,
            'roleNames' => $roleNames,
        ]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegister()
    {
        $model = new RegistrationForm();

        if ($model->load(Yii::$app->request->post())) {
            // dump($model); die;
            if($model->register()){
                Yii::$app->session->setFlash('success', 'Registration successful!');
                return $this->redirect(['login']); 
            }
            else{
                Yii::$app->session->setFlash('failed', 'Registration failed!');
                return $this->redirect(['#']); 
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $literature = new Literature();

        if ($literature->load(Yii::$app->request->post()) && $literature->save()) {
            return $this->redirect(['view', 'id' => $literature->id]);
        }

        return $this->render('create', [
            'model' => $literature,
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

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionError()
{
    $exception = Yii::$app->errorHandler->exception;
    if ($exception !== null) {
        return $this->render('error', ['exception' => $exception]);
    }
}
}
