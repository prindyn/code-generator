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

    <?php if(isset($session['added']) || isset($session['notadded'])): ?>

       <?php if(isset($session['added'])): ?>
        
            <h1><?= Html::encode('Created Codes') ?></h1>
            <div class="alert alert-success" role="alert">
            <?php foreach($added as $item): ?>
            <?php echo '<p>'. $item .'</p>'; ?>
            <?php endforeach; ?>
            </div>

        <?php unset($session['added']) ?>
        <?php endif; ?>

        <?php if(isset($session['notadded']) && $session['notadded'] != ''): ?>
    
            <h1><?= Html::encode('Not Created Codes. These Codes Already Exist') ?></h1>
            <div class="alert alert-danger" role="alert">
            <?php foreach($added as $item): ?>
            <?php echo $item. '<br>'; ?>
            <?php endforeach; ?>
            </div>

        <?php unset($session['notadded']) ?>
        <?php endif; ?>

        <?php else: ?>

            <h1><?= Html::encode('You Can Create Codes') ?></h1>
            <div class="alert alert-info" role="alert">
            Press on "Create 10 Random Codes" to create codes
            </div>

    <?php endif; ?>

</div>