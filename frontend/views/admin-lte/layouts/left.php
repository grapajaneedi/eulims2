<?php
use common\models\system\User;
use common\models\system\Package;
use common\models\system\PackageDetails;
use yii\helpers\Url;

$Packages= Package::find()->all();

$Request_URI=$_SERVER['REQUEST_URI'];
//$_SERVER['SERVER_NAME']
if($Request_URI=='/'){//alias ex: http://admin.eulims.local
    $Backend_URI=Url::base();//Yii::$app->urlManagerBackend->createUrl('/');
    $Backend_URI=$Backend_URI."/uploads/user/photo/";
}else{//http://localhost/eulims/backend/web
    $Backend_URI=Url::base().'/uploads/user/photo/';
}
Yii::$app->params['uploadUrl']=$Backend_URI;
if(Yii::$app->user->isGuest){
    $CurrentUserName="Visitor";
    $CurrentUserAvatar=Yii::$app->params['uploadUrl'] . 'no-image.png';
    $CurrentUserDesignation='Guest';
    $UsernameDesignation=$CurrentUserName;
}else{
    $CurrentUser= User::findOne(['user_id'=> Yii::$app->user->identity->user_id]);
    $CurrentUserName=$CurrentUser->profile ? $CurrentUser->profile->fullname : $CurrentUser->username;
    if($CurrentUser->profile){
        $CurrentUserAvatar=!$CurrentUser->profile->getImageUrl()=="" ? Yii::$app->params['uploadUrl'].$CurrentUser->profile->getImageUrl() : Yii::$app->params['uploadUrl'] . 'no-image.png';
    }else{
        $CurrentUserAvatar=Yii::$app->params['uploadUrl'] . 'no-image.png';
    }
    $CurrentUserDesignation=$CurrentUser->profile ? $CurrentUser->profile->designation : '';
    if($CurrentUserDesignation==''){
       $UsernameDesignation=$CurrentUserName;
    }else{
       $UsernameDesignation=$CurrentUserName.'<br>'.$CurrentUserDesignation;
    }
}
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $CurrentUserAvatar ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= $UsernameDesignation ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <?php
        $Menu= Package::find()->orderBy(['PackageName'=>SORT_ASC])->all();
        $init=true;
        foreach ($Menu as $MenuItems => $Item) {
            $modulePermission="access-".strtolower($Item->PackageName);
            $MenuItems= PackageDetails::find()->orderBy(['Package_Detail'=>SORT_ASC])->where(['PackageID'=>$Item->PackageID])->all();
            $ItemSubMenu[]=[
                'label' => '<img src="/images/icons/dashboard.png" style="width:20px">  <span>' . 'Dashboard' . '</span>', 
                'icon'=>' " style="display:none;width:0px"',
                'url'=>["/".strtolower($Item->PackageName)],
                'visible'=>true
            ];
          
            //$ItemSubMenu[]=[];
            foreach ($MenuItems as $MenuItem => $mItem){
                $icon=substr($mItem->icon,6,strlen($mItem->icon)-6);
                $pkgdetails1=strtolower($mItem->Package_Detail);
                $pkgdetails2=str_replace(" ","-",$pkgdetails1);
                $SubmodulePermission="access-".$pkgdetails2; //access-Order of Payment
                $ItemS=[
                   'label' =>'<img src="/images/icons/' .$mItem->icon. '.png" style="width:20px">  <span>' . $mItem->Package_Detail . '</span>', 
                   'icon'=>' " style="display:none;width:0px"',
                   'url'=>[$mItem->url],
                   'visible'=>Yii::$app->user->can($SubmodulePermission)
                ];
                array_push($ItemSubMenu, $ItemS);
            }
            $MainIcon=substr($Item->icon,6,strlen($Item->icon)-6);
            $ItemMenu[]=[
                'label' => '<img src="/images/icons/' .$Item->icon. '.png" style="width:20px">  <span>' . ucwords($Item->PackageName) . '</span>', 
                'icon'=>' " style="display:none;width:0px"',
                'url' => ["/".$Item->PackageName."/index"],
                'items'=>$ItemSubMenu,
                'visible'=>Yii::$app->user->can($modulePermission)
            ]; 
            unset($ItemSubMenu);
        }
        // Fixed Sub Menu Item
        $SubItem=[
            'label' => '<img src="/images/icons/' .$Item->icon. '.png" style="width:20px">  <span>System</span>', 
            'icon'=>' " style="display:none;width:0px"',
            'url' => ["#"],
            'items'=>[
                [
                    'label' => '<img src="/images/icons/' .$Item->icon. '.png" style="width:20px">  <span>API Configuration</span>', 
                    'icon'=>' " style="display:none;width:0px"',
                    'url' => ["/system/api/config"],
                    'visible'=>Yii::$app->user->can('access-api-config')
                ]
            ],
            'visible'=>Yii::$app->user->can('access-system')
        ];
        array_push($ItemMenu, $SubItem);
        ?>
         <?php echo dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => $ItemMenu,
                'encodeLabels' => false,
            ]
        );
        ?>
    </section>

</aside>
