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
                    //'delete' => $_POST['delete'],
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
        //Output a list of all codes using dataProvider of Yii2
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
        //We send information about created codes to the index page. If they exist - will be displayed
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
                //create array of codes which added to database
                $addedCodes[] = [$randomCode, date('Y-m-d H:i:s')];
                $added[] = $randomCode;
            }else{
                //create array of codes which already exist and can't be added
                $notaddedCodes[] = $randomCode;
                $notadded[] = $randomCode;
            }
            $i++;
        }
        
        //add the codes to database
        Yii::$app->db->createCommand()->batchInsert('code', ['code_item', 'created_at'], $addedCodes
        )->execute();

        
        //create session values which will be send to index page 
        $session['added'] = $added;
        $session['notadded'] = $notadded;

        return $this->redirect(['index']);

    }

    /**
     * Deletes an existing Code model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        $model = new Code();
        $session = Yii::$app->session;
        $codes = [];
        //create list of issets codes
        $issetCodes = $model->find()->select('code_item')->all();
        foreach($issetCodes as $item){
            $codes[] = $item->code_item;
        }
        //clear the user request
        if($model->load(Yii::$app->request->post())){
            $chosenCodes = Yii::$app->request->post();
            $chosenCodes = $chosenCodes['Code']['code_item'];
            $deleteCodes = array_diff(preg_split("/[\s-!.,]/", $chosenCodes), ['']);
           //create arrays of remote codes that exist in the database, and not removed, which do not exist
            foreach($deleteCodes as $key => $item){

               if(in_array($item, $codes)){
                    $deleted[] = $item; 
               }else{
                    $notdeleted[] = $item;
               }

            }

            if(!empty($notdeleted)){
                $session['notdeleted'] = $notdeleted;
                $errorMessage = 'Error. One or more codes do not exist in the database. Codes have not been removed from the database.';
            }else{
                $successMessage = 'The following codes have been deleted from the database';
                $session['deleted'] = $deleted;
                //delete codes and create in session deleted and not deleted codes, which send to user
                Yii::$app->db->createCommand()->delete('code', ['code_item' => $deleted])->execute();
            }

            
            
            
        }
        
        return $this->render('delete', [
            'deleted' => $deleted,
            'notdeleted' => $notdeleted,
            'errorMessage' => $errorMessage,
            'successMessage' => $successMessage
        ]);





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

    public function actionReset()
    {
        return $this->redirect(['delete']);
    }
}
