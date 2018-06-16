<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\Code;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Delete Codes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="code-index">

    <?php $session = Yii::$app->session; ?>
    <!-- Check if isset session values deleted codes and not deleted -->
    <?php if(isset($deleted) || isset($notdeleted)): ?>
    
       <?php if(isset($deleted) && !empty($deleted)): ?>
            <!-- show deleted codes -->
            <h1><?= Html::encode('Deleted Codes') ?></h1>
            <div class="alert alert-success" role="alert">
            <?php foreach($deleted as $item): ?>
            <?php echo '<p>'. $item .'</p>'; ?>
            <?php endforeach; ?>
            </div>
        <!-- Unset session values deleted codes -->
        <?php unset($session['deleted']) ?>
        <?php endif; ?>

        <?php if(isset($notdeleted) && !empty($notdeleted)): ?>
            <!-- show not deleted codes -->
            <h1><?= Html::encode('Not Deleted Codes. These Codes Not Exist') ?></h1>
            <div class="alert alert-danger" role="alert">
            <?php foreach($notdeleted as $item): ?>
            <?php echo $item. '<br>'; ?>
            <?php endforeach; ?>
            </div>
        <!-- Unset session values notdeleted codes -->
        <?php  unset($session['notdeleted']) ?>
        <?php endif; ?>

        <?php else: ?>
            <!-- If dont exist any codes (deleted or not deleted) show message -->
            <h1><?= Html::encode('You Can Delete Codes') ?></h1>
            <div class="alert alert-info" role="alert">
            Please enter the list of codes that you want to delete (delimited by comma, space, or enter key)
            </div>

    <?php endif; ?>

    <?php $model = new Code(); ?>
    <!-- Show text area -->
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'code_item')->textarea(['rows' => 10]); ?>

        <div class="form-group">
            <?= Html::submitButton('Delete', ['class' => 'btn btn-danger']) ?>
            <?= Html::a('Reset Form', ['reset'], ['class' => 'btn btn-warning']) ?>
        </div>

    <?php ActiveForm::end(); ?>



</div>