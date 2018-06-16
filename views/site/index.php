<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\Code */

$this->title = 'Created Code';
$this->params['breadcrumbs'][] = ['label' => 'Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="code-create">

    <?php $session = Yii::$app->session; ?>
    <!-- Check if isset session values added codes and not added -->
    <?php if(isset($added) || isset($notadded)): ?>

       <?php if(isset($added) && !empty($added)): ?>
            <!-- show added codes -->
            <h1><?= Html::encode('Created Codes') ?></h1>
            <div class="alert alert-success" role="alert">
            <?php foreach($added as $item): ?>
            <?php echo '<p>'. $item .'</p>'; ?>
            <?php endforeach; ?>
            </div>
        <!-- Unset session values added codes -->
        <?php unset($session['added']) ?>
        <?php endif; ?>

        <?php if(isset($notadded) && !empty($notadded)): ?>
            <!-- show notadded codes -->
            <h1><?= Html::encode('Not Created Codes. These Codes Already Exist') ?></h1>
            <div class="alert alert-danger" role="alert">
            <?php foreach($notadded as $item): ?>
            <?php echo $item. '<br>'; ?>
            <?php endforeach; ?>
            </div>
        <!-- Unset session values notadded codes -->
        <?php unset($session['notadded']) ?>
        <?php endif; ?>

        <?php else: ?>
            <!-- If dont exist any codes (added or not added) show message -->
            <h1><?= Html::encode('You Can Create Codes') ?></h1>
            <div class="alert alert-info" role="alert">
            Press on "Create 10 Random Codes" to create codes
            </div>

    <?php endif; ?>

</div>