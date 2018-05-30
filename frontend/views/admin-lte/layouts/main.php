<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {
    frontend\assets\AppAsset::register($this);
    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title>EULIMS | <?= Html::encode($this->title) ?></title>
        <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />
        <?php $this->head() ?>
        <?php echo PHP_EOL; ?>
        <script type="text/javascript">
            function PreviewReport(PDFUrl){
                /*
                * This Function will preview Generated PDF
                * With the given URL of PDF Action
                */
                //alert(PDFUrl);
                var url="/reports/preview?url="+PDFUrl;
                window.open(url, '_blank');
            }
        </script>
    </head>
    <body class="hold-transition skin-blue sidebar-collapse">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
