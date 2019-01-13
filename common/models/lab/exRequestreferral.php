<?php

/*
 *
 * Module: exReferralrequest * 
 */

namespace common\models\lab;
use Yii;
use common\models\lab\Request;
/**
 * @property int $hasop
 *
 * @author OneLab
 */
class exRequestreferral extends Request{
	 
	public $sample_receive_date;
	public $customer_name;
    public $modeofreleaseids;
    public $request_date;
	
	/**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rstl_id', 'lab_id', 'customer_id', 'payment_type_id', 'discount_id', 'purpose_id', 'report_due', 'conforme', 'receivedBy', 'created_at','request_type_id','sample_receive_date','modeofrelease_ids'], 'required'],
			[['request_datetime', 'report_due', 'recommended_due_date', 'est_date_completion', 'equipment_release_date', 'certificate_release_date'], 'safe'],
            [['rstl_id', 'lab_id', 'customer_id', 'payment_type_id', 'discount_id', 'purpose_id', 'created_at', 'posted', 'status_id', 'selected', 'request_type_id','payment_status_id'], 'integer'],
            [['discount', 'total'], 'number'],
            [['request_ref_num', 'modeofrelease_ids', 'conforme', 'receivedBy'], 'string', 'max' => 50],
            [['position', 'items_receive_by', 'released_by', 'received_by'], 'string', 'max' => 100],
            [['request_ref_num'], 'unique'],
            [['lab_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lab::className(), 'targetAttribute' => ['lab_id' => 'lab_id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'customer_id']],
            [['discount_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discount::className(), 'targetAttribute' => ['discount_id' => 'discount_id']],
            [['purpose_id'], 'exist', 'skipOnError' => true, 'targetClass' => Purpose::className(), 'targetAttribute' => ['purpose_id' => 'purpose_id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'status_id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'customer_id']],
            [['payment_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paymenttype::className(), 'targetAttribute' => ['payment_type_id' => 'payment_type_id']],
        ];
    }
	
	public function beforeSave($insert) {
        if ($insert) {
            $this->request_datetime='0000-00-00 00:00:00';
			$this->request_ref_num=NULL;
        }
        return parent::beforeSave($insert);
    }
	
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
			'request_id' => 'Request ID',
            'request_ref_num' => 'Request Ref Num',
            'request_datetime' => 'Request Datetime',
            'rstl_id' => 'Rstl ID',
            'lab_id' => 'Laboratory',
            'customer_id' => 'Customer',
            'payment_type_id' => 'Payment Type',
            'modeofrelease_ids' => 'Mode of release',
            'modeofreleaseids' => 'Mode of Release',
            'discount' => 'Discount',
            'discount_id' => 'Discount',
            'purpose_id' => 'Purpose',
            'total' => 'Total',
            'report_due' => 'Estimated Due Date',
            'conforme' => 'Conforme',
            'receivedBy' => 'Received By',
            'created_at' => 'Created At',
            'posted' => 'Posted',
            'status_id' => 'Status',
            //'customer_name'=>'Customer Name',
            'selected' => 'Selected',
            'request_type_id' => 'Request Type', 
            'position' => 'Position',
            'recommended_due_date' => 'Recommended Due Date',
            'est_date_completion' => 'Estimated Date of Completion',
            'items_receive_by' => 'Items Receive By',
            'equipment_release_date' => 'Date Release of Equipment',
            'certificate_release_date' => 'Date Release of Certificate',
            'released_by' => 'Released By',
            'received_by' => 'Received By',
            'payment_status_id'=>'Payment Status',
            'sample_receive_date' => 'Sample Received Date'
        ];
		
    }

    //check testname method offered by agencies
    public static function getMatchingAgencies($referralId)
    {
        //$referral = Referral::model()->findByPk($referralId);
        /*
        $crit = new CDbCriteria;
        $crit->select = array('*');
        $crit->with = 'sample';
        $crit->condition = 't.package != :package AND sample.referral_id = :referralId';
        $crit->params = array(':package'=>2,':referralId' => $referralId);
        
        $crit1 = new CDbCriteria;
       //$crit1->select = 'analyses.package_id';
        $crit1->with = 'analyses';
        $crit1->condition = 'analyses.package = :package AND analyses.package_id !=:packageId AND t.referral_id = :referralId';
        $crit1->params = array(':package'=>2,':packageId'=>0,':referralId' => $referralId);
    
        $analyses = Analysis::model()->findAll($crit);
        $packages1 = Sample::model()->findAll($crit1);
    
        $count = 0;
        $count1 = 0;
        $count2 = 0;
        $method_ref_ids = array();
        $package_ids = array();
        $package_ids1 = array();
        $agency_ids = array();
        //$checkAgencylabs = array();

        foreach($analyses as $analysis)
        {
            if(!in_array($analysis->methodReference_id, $method_ref_ids))
            {
                array_push($method_ref_ids, $analysis->methodReference_id);
                $count += 1;
            }
            if(!in_array($analysis->package_id, $package_ids))
            {
                if($analysis->package_id > 0 )
                {
                    array_push($package_ids, $analysis->package_id);
                    $count1++;
                }
            }
        }
        
        $criteria = new CDbCriteria;
        //$criteria->select = array('*, COUNT(method_ref_id) AS methodMatches');
        $criteria->select = array('*, COUNT(method_ref_id) AS methodMatches');
        //$criteria->with = 'agency';
        $criteria->group = 'agency_id';
        $criteria->having = 'methodMatches = :methodMatches';
        $criteria->params = array(':methodMatches' => $count);
        $criteria->addInCondition('method_ref_id', $method_ref_ids);
    
        $agencies = Service::model()->with('agency')->findAll($criteria);
        $forPackage = Service::model()->findAll($criteria);
        
        $arrayAgencies = CJSON::decode(CJSON::encode($forPackage));
        
        //check if lab is inactive
        // $critchecklab = new CDbCriteria;
        // $critchecklab->join = 'INNER JOIN referral ON t.lab_id = referral.lab_id'; 
        // $critchecklab->condition = 't.status = :status AND referral.id = :referralId';
        // $critchecklab->params = array(':status'=>0,':referralId' => $referralId);
        // $checkLabstatus = Agencyactivelab::model()->findAll($critchecklab);
        // $arrayCheckLabstatus = CJSON::decode(CJSON::encode($checkLabstatus));
        
        if(count($arrayAgencies) > 0)
        {
            foreach($arrayAgencies as $agency)
            {
                array_push($agency_ids, $agency['agency_id']);
            }
            $analysis_agency_ids = implode(',',$agency_ids);
            $analysis_package_ids = implode (',', $package_ids);
            if(count($package_ids) > 0 && count($analysis_package_ids) && count($analysis_agency_ids)){
                $packageOffered = Yii::app()->db->createCommand(
                "SELECT * 
                    FROM package_offer
                    WHERE (agency_id IN (".$analysis_agency_ids.")) AND (package_id IN (".$analysis_package_ids."))"
                )->queryAll();
            }
        }
        
        if(count($package_ids) > 0 && count($packageOffered) == 0){
            return null;
        } else  {
            // if(count($checkAgencylabs) > 0 && count($labStatus) > 0)
                // return null;
            // else
                return $agencies;
        }
        */
    }

}
