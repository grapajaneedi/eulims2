<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\system\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\components\SwiftMessage;
use common\models\system\User;
use dosamigos\google\places\Search;
use common\models\auth\AuthAssignment;
use common\models\system\Profile;
use yii\db\Query;
use common\models\inventory\Products;
use common\models\inventory\Categorytype;
use common\models\inventory\Producttype;
//use yii\swiftmailer\Message;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup','requestpasswordreset'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionQuery(){
        $inventorydb= Yii::$app->get('inventorydb');
        /*$query=new Query();
        $query->select(['`product_code`, `product_name`, `tbl_producttype`.`producttype`,`tbl_categorytype`.`categorytype`'])
                ->from('`tbl_products`')
                ->innerJoin('`tbl_producttype`', '`tbl_producttype`.`producttype_id`=`tbl_products`.`producttype_id`')
                ->innerJoin('`tbl_categorytype`', '`tbl_categorytype`.`categorytype_id`=`tbl_products`.`categorytype_id`')
                ->where(['`tbl_products`.`product_id`'=>2]);
        $command=$query->createCommand($inventorydb);
        $products=$command->queryAll();
         * 
         */
        $products= Products::find()
                ->innerJoin('`tbl_producttype`', '`tbl_producttype`.`producttype_id`=`tbl_products`.`producttype_id`')
                ->innerJoin('`tbl_categorytype`', '`tbl_categorytype`.`categorytype_id`=`tbl_products`.`categorytype_id`')
                ->where(['`tbl_products`.`product_id`'=>1])
                ->all();
        echo "<pre>";
        print_r($products);
        echo "</pre>";
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex(){
        
        $listLab = array("Chemical", "Microbiology", "Metrology", "Rubber", "Test Lab", "Test Lab2", "Test Lab3","New Members","New Referrals");
        $listLabCode = array("Chemical", "Microbiology", "Metrology", "Rubber", "TestLab", "TestLab2", "TestLab3","","");
        $listLabCount = array(400, 500, 600, 700, 800, 900, 1000,6,8);
        $listLabColor = array("red", "green", "blue", "orange", "aqua", "purple", "orange","gray","gray");
        $listLabIcons = array("fa fa-comments-o", "fa fa-thumbs-o-up", "fa fa-bookmark-o", "fa fa-comments-o", "fa fa-bookmark-o", "fa fa-comments-o", "fa fa-bookmark-o","fa fa-bookmark-o","fa fa-bookmark-o");
        $listYear = array("2015","2016","2017");
        $listColumn = array("Rank", "Test Name", "No. of Tests");
        $dataTop10 = array(
            array('rank' => '1', 'test' => 'Test Chemical 1', 'count' => 300, 'type' => 'Chemical'),
            array('rank' => '2', 'test' => 'Test Chemical 2', 'count' => 301, 'type' => 'Chemical'),
            array('rank' => '3', 'test' => 'Test Chemical 3', 'count' => 302, 'type' => 'Chemical'),
            array('rank' => '4', 'test' => 'Test Chemical 4', 'count' => 303, 'type' => 'Chemical'),
            array('rank' => '5', 'test' => 'Test Chemical 5', 'count' => 304, 'type' => 'Chemical'),
             array('rank' => '6', 'test' => 'Test Chemical 1', 'count' => 300, 'type' => 'Chemical'),
            array('rank' => '7', 'test' => 'Test Chemical 2', 'count' => 301, 'type' => 'Chemical'),
            array('rank' => '8', 'test' => 'Test Chemical 3', 'count' => 302, 'type' => 'Chemical'),
            array('rank' => '9', 'test' => 'Test Chemical 4', 'count' => 303, 'type' => 'Chemical'),
            array('rank' => '10', 'test' => 'Test Chemical 5', 'count' => 304, 'type' => 'Chemical'),

            array('rank' => '1', 'test' => 'Test Chemical 1', 'count' => 300, 'type' => 'TestLab3'),
            array('rank' => '2', 'test' => 'Test Chemical 2', 'count' => 301, 'type' => 'TestLab3'),
            array('rank' => '3', 'test' => 'Test Chemical 3', 'count' => 302, 'type' => 'TestLab3'),
            array('rank' => '4', 'test' => 'Test Chemical 4', 'count' => 303, 'type' => 'TestLab3'),
            array('rank' => '5', 'test' => 'Test Chemical 5', 'count' => 304, 'type' => 'TestLab3')
        );
        
        $dataGraphCalibration = array(
            array('type'=>'column', 'name' => 'Chemical', 'data' => array(50, 60, 70), 'color' => 'red'),
            array('type'=>'column','name' => 'Microbiology', 'data' => array(150, 120, 140), 'color' => 'green'),
            array('type'=>'column','name' => 'Metrology', 'data' => array(200, 180, 210), 'color' => 'blue'),
            array('type'=>'column','name' => 'Rubber', 'data' => array(250, 240, 280), 'color' => 'orange'),
            array('type'=>'column','name' => 'TestLab', 'data' => array(300, 300, 350), 'color' => 'aqua')
        );
         
        $dataGraphPie2017 = array(
                array('name' => 'Chemical', 'y' => 20, 'sliced' => 'true','color'=>'red'),
                array('name' => 'Microbiology', 'y' => 50, 'sliced' => 'true','color'=>'green'),
                array('name' => 'Metrology', 'y' => 15, 'sliced' => 'true','color'=>'blue'),
                array('name' => 'Rubber', 'y' => 15, 'sliced' => 'true','color'=>'orange'),
            );
        
        $datainitial = array();
        $datainitial['listlab']=$listLab;
        $datainitial['listlabcode']=$listLabCode;
        $datainitial['listlabcount']=$listLabCount;
        $datainitial['listlabcolor']=$listLabColor;
        $datainitial['listlabicons']=$listLabIcons;
        $datainitial['listyear']=$listYear;
        $datainitial['listcolumn']=$listColumn;
        $datainitial['datatop10']=$dataTop10;
        
        $datainitial['column'] = $dataGraphCalibration;
        $datainitial['pie'] = $dataGraphPie2017; 
        
        
    
        return $this->render('index', array('data'=>$datainitial));
     
     //   return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about'); 
    }
    public function actionSendmail(){
        $mailer= \Yii::$app->mailer;
        $mailer->compose('sampleEmail-html', ['message' => 'Nolan'])
                ->setFrom('nolansunico@gmail.com')
                ->setTo('nolansunico@gmail.com')
                ->setBcc('nolan@tailormadetraffic.com')
                ->attach('d:/attachment.png')
                ->attach('d:/Sample.txt')
                ->setReplyTo('admin@eulims.com')
                ->setSubject('This message was sent to you by: ' . \Yii::$app->name)
                ->send();
    }
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user=$model->signup()) {
                //Send email Verification
                $model->SendEmail($user);
                return $this->runAction('success', ['model' => $user]);
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    public function actionSuccess($model){
        return $this->render('success', [
            'model' => $model,
        ]);
    }
    public function actionVerify(){
        $get= Yii::$app->request->get();
        $user= User::find()->where("md5(user_id)='".$get['id']."'")->one();
        if ($user) {
            $mUser= User::findOne(['user_id'=>$user->user_id]);
            //Update User
            $mUser->status = 10;
            $mUser->save();
            //Assign default Role  basic-role
            $BasicRole = 'basic-role';
            //search existing assignment
            $AAssignment= AuthAssignment::find()->where(['item_name'=>$BasicRole]);
            if (!$AAssignment) {
                $AuthAssignment = new AuthAssignment();
                $AuthAssignment->item_name = $BasicRole;
                $AuthAssignment->user_id = (string) $user->user_id;
                $AuthAssignment->save();
            }
            return $this->render('verify');
        }else{
            return $this->render('expired');
        }
        
    }
    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestpasswordreset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    
    public function actionRetrievechart()
        {
        
         $pYear = Yii::$app->request->post('yearParam');
         $dataGraphPie="";
         
                  
            $dataGraphPie2015 = array(
            array('name' => 'Chemical', 'y' => 40, 'sliced' => 'true','color'=>'red'),
            array('name' => 'Microbiology', 'y' => 30, 'sliced' => 'true','color'=>'green'),
            array('name' => 'Metrology', 'y' => 20, 'sliced' => 'true','color'=>'blue'),
            array('name' => 'Rubber', 'y' => 10, 'sliced' => 'true','color'=>'orange'),
            );

            $dataGraphPie2016 = array(
                array('name' => 'Chemical', 'y' => 10, 'sliced' => 'true','color'=>'red'),
                array('name' => 'Microbiology', 'y' => 10, 'sliced' => 'true','color'=>'green'),
                array('name' => 'Metrology', 'y' => 10, 'sliced' => 'true','color'=>'blue'),
                array('name' => 'Rubber', 'y' => 70, 'sliced' => 'true','color'=>'orange'),
            );

            $dataGraphPie2017 = array(
                array('name' => 'Chemical', 'y' => 20, 'sliced' => 'true','color'=>'red'),
                array('name' => 'Microbiology', 'y' => 50, 'sliced' => 'true','color'=>'green'),
                array('name' => 'Metrology', 'y' => 15, 'sliced' => 'true','color'=>'blue'),
                array('name' => 'Rubber', 'y' => 15, 'sliced' => 'true','color'=>'orange'),
            );
      
        switch ($pYear) {
        case '2015':
           $dataGraphPie = $dataGraphPie2015;
            break;
        case '2016':
            $dataGraphPie = $dataGraphPie2016;
            break;
        case '2017':
           $dataGraphPie = $dataGraphPie2017;
            break;
        
        default:
           break;
        } 
           
            
           
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $dataGraphPie;
            //return \yii\helpers\Json::encode($dataGraphPie2017);
           // return json_encode($dataGraphPie2017, JSON_NUMERIC_CHECK);
        }
        
        public function actionRetrievecolumn()
        {
        
         $cType = Yii::$app->request->post('columnType');
         $dataGraphColumn="";
         
                  
        $dataGraphIncome = array(
            array('type'=>'column', 'name' => 'Chemical', 'data' => array(194, 277, 81), 'color' => 'red'),
            array('type'=>'column', 'name' => 'Microbiology', 'data' => array(237, 334, 89), 'color' => 'green'),
            array('type'=>'column', 'name' => 'Metrology', 'data' => array(748, 270, 109), 'color' => 'blue'),
            array('type'=>'column', 'name' => 'Rubber', 'data' => array(100, 200, 300), 'color' => 'orange'),
            array('type'=>'column','name' => 'TestLab', 'data' => array(450, 200, 360), 'color' => 'aqua')
              );

        $dataGraphFirms = array(
            array('type'=>'column', 'name' => 'Chemical', 'data' => array(294, 377, 181), 'color' => 'red'),
            array('type'=>'column','name' => 'Microbiology', 'data' => array(137, 234, 189), 'color' => 'green'),
            array('type'=>'column','name' => 'Metrology', 'data' => array(648, 370, 209), 'color' => 'blue'),
            array('type'=>'column','name' => 'Rubber', 'data' => array(200, 400, 600), 'color' => 'orange'),
            array('type'=>'column','name' => 'TestLab', 'data' => array(450, 200, 360), 'color' => 'aqua')
        );
        
        $dataGraphAssistance = array(
            array('type'=>'column', 'name' => 'Chemical', 'data' => array(80, 90, 20), 'color' => 'red'),
            array('type'=>'column','name' => 'Microbiology', 'data' => array(160, 180, 40), 'color' => 'green'),
            array('type'=>'column','name' => 'Metrology', 'data' => array(240, 270, 60), 'color' => 'blue'),
            array('type'=>'column','name' => 'Rubber', 'data' => array(300, 360, 80), 'color' => 'orange'),
            array('type'=>'column','name' => 'TestLab', 'data' => array(360, 450, 100), 'color' => 'aqua')
        );
      
        
        $dataGraphCalibration = array(
            array('type'=>'column', 'name' => 'Chemical', 'data' => array(50, 60, 70), 'color' => 'red'),
            array('type'=>'column','name' => 'Microbiology', 'data' => array(150, 120, 140), 'color' => 'green'),
            array('type'=>'column','name' => 'Metrology', 'data' => array(200, 180, 210), 'color' => 'blue'),
            array('type'=>'column','name' => 'Rubber', 'data' => array(250, 240, 280), 'color' => 'orange'),
            array('type'=>'column','name' => 'TestLab', 'data' => array(300, 300, 350), 'color' => 'aqua')
        );
      
        $dataGraphCustomer = array(
            array('type'=>'column', 'name' => 'Chemical', 'data' => array(10, 100, 200), 'color' => 'red'),
            array('type'=>'column','name' => 'Microbiology', 'data' => array(20, 200, 210), 'color' => 'green'),
            array('type'=>'column','name' => 'Metrology', 'data' => array(30, 300, 220), 'color' => 'blue'),
            array('type'=>'column','name' => 'Rubber', 'data' => array(40, 400, 230), 'color' => 'orange'),
            array('type'=>'column','name' => 'TestLab', 'data' => array(50, 500, 240), 'color' => 'aqua')
        );
        
        switch ($cType) {
        case 'firms':
           $dataGraphColumn = $dataGraphFirms;
            break;
        case 'income':
            $dataGraphColumn = $dataGraphIncome;
            break;
        case 'assistance':
           $dataGraphColumn = $dataGraphAssistance;
            break;
        case 'calibration':
           $dataGraphColumn = $dataGraphCalibration;
            break;
        case 'customer':
           $dataGraphColumn = $dataGraphCustomer;
            break;
        
        default:
           break;
        } 
      
      
       
           
            
           
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $dataGraphColumn;
        //   return \yii\helpers\Json::encode($dataGraphIncome);
           // return json_encode($dataGraphPie2017, JSON_NUMERIC_CHECK);
            
        }
    
    
}
