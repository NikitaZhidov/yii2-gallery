<?php

namespace app\controllers;

use app\models\Image;
use app\models\CaptionImageForm;
use app\models\ImageItemForm;
use app\models\UploadForm;
use app\models\DeleteImageForm;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UploadedFile;

class GalleryController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'upload', 'edit', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'upload', 'edit', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['auth/login']);
                }
            ],
        ];
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isPost) {
            $postRequset = Yii::$app->request->post();

            if ($postRequset["DeleteImageForm"]) {
                $imageId = $postRequset["DeleteImageForm"]["id"];
                $image = Image::findOne(["id" => intval($imageId)]);
                $image->delete();
            }

            if ($postRequset["ImageItemForm"]) {

                $caption = $postRequset["ImageItemForm"]["caption"];
                $name = $postRequset["ImageItemForm"]["name"];

                $image = new Image();

                $image->caption = $caption;
                $image->name = $name;

                $image->save();
            }
        }

        $query = Image::find();

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 4]);

        $images = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $addImageForm = new UploadForm();

        return $this->render('index', [
            'images' => $images,
            'pages' => $pages,
            'addImageForm' => $addImageForm
        ]);
    }

    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if (($imageName = $model->upload()) != NULL) {
                $imageItemForm = new ImageItemForm();
                return $this->render('upload', [
                    'imageItemForm' => $imageItemForm,
                    'imageName' => "upload/" . $imageName
                ]);
            } else {
                return $this->render('error', [
                    'error_message' => 'Upload image error'
                ]);
            }
        }

        return $this->render('error', [
            'error_message' => 'Upload the photo on gallery page'
        ]);
    }

    public function actionEdit($id)
    {
        $image = Image::find()->where(['id' => $id])->one();
        if (Yii::$app->request->isPost) {
            $image->caption = Yii::$app->request->post()["Image"]["caption"];
            $image->save();
            return $this->redirect(['gallery/index']);
        }
        $editForm = new CaptionImageForm();
        return $this->render('edit', [
            'image' => $image,
            'editForm' => $editForm
        ]);
    }

    public function actionDelete($id)
    {
        $image = Image::find()->where(['id' => $id])->one();

        $deleteImageForm = new DeleteImageForm();

        return $this->render('delete', [
            'image' => $image,
            'deleteImageForm' => $deleteImageForm
        ]);
    }

    public function actionError()
    {
        return $this->render('error', [
            'error_message' => "404 not found"
        ]);
    }
}
