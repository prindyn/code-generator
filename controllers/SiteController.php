<?php

namespace app\controllers;

use Yii;
use app\models\Code;
use app\models\CodeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CodeController implements the CRUD actions for Code model.
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Code models.
     * @return mixed
     */
    public function actionView()
    {
        echo ($session['added']);
        $searchModel = new CodeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Code model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionIndex()
    {
        //Open session
        $session = Yii::$app->session;

        return $this->render('index', [
            'added' => $session['added'],
            'notadded' => $session['notadded']
        ]);

        
    }

    /**
     * Creates a new Code model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {   
        $session = Yii::$app->session;
        
        $model = new Code();
        $codes = [];
        //create list of issets codes
        $issetCodes = $model->find()->select('code_item')->all();
        foreach($issetCodes as $item){
            $codes[] = $item->code_item;
        }
        //generate 10 random codes
        $i = 0;
        while($i<10){
            $randomCode = $this->generateCode();
            if(!in_array($randomCode, $codes)){
                $addedCodes[] = [$randomCode, date('Y-m-d H:i:s')];
                $added[] = $randomCode;
            }else{
                $notaddedCodes[] = $randomCode;
                $notadded[] = $randomCode;
            }
            $i++;
        }
        //add the codes to database
        Yii::$app->db->createCommand()->batchInsert('code', ['code_item', 'created_at'], $addedCodes
        )->execute();

        

        $session['added'] = $added;
        $session['notadded'] = $notadded;

        return $this->redirect(['index']);

    }

    /**
     * Updates an existing Code model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Code model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Code model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Code the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Code::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
    *
    *Function generate a random code
    *
    **/
    protected function generateCode($length = 80)
    {
        $num = range(0, 9);
        $alf = range('a', 'z');
        $_alf = range('A', 'Z');
        
        $symbols = array_merge($num, $alf, $_alf);
        shuffle($symbols);
        
        $code_array = array_slice($symbols, 0, (int)$length);
        $code = implode("", $code_array);
        
        return $code;
    }
}
