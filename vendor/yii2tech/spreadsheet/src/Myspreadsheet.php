<?php

namespace yii2tech\spreadsheet;

use yii2tech\spreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use common\models\lab\Lab;

 /**
* Bergel Cutara SRS-II
*/
class Myspreadsheet extends Spreadsheet
{

	/**
     * @var location the data provider for the view. This property is required.
     */
	public $location="";
    public $model; // model used for targeting specific cell for data placements
    public $template; //templates to be used
     //public $LOCATION =\Yii::$app->basePath.'\\modules\\reports\\modules\\lab\\templates\\';
    /**

	/**
     * @param \PhpOffice\PhpSpreadsheet\Spreadsheet|null $document spreadsheet document representation instance.
     */

	public function init(){
		$this->location = \Yii::$app->basePath.'\\modules\\reports\\modules\\lab\\templates\\';
	}

    public function loaddoc()
    {
        $labprefix = ""; //used to store string variable for lab use

    	 // $location = \Yii::$app->basePath.'\\modules\\reports\\modules\\lab\\templates\\';
    	// echo $this->location; exit;
        //$this->_document = $document;
        // $this->_document = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
        //cehck on what lab the testreport will be generated
        $lab = Lab::findOne($this->model->lab_id);
        if($lab->labcode=="CHE"){
            $labprefix="CHEM";
        }elseif($lab->labcode=="MIC"){
            $labprefix="MICRO";
        }
        //choose what template to use
        switch($this->template){
            case "ISO":
                $this->setDocument(IOFactory::load($this->location.$labprefix."_ISO.xlsx"));
            case "NON-ISO":
                $this->setDocument(IOFactory::load($this->location.$labprefix."_NONISO.xlsx"));
            case "EMB":
                $this->setDocument(IOFactory::load($this->location.$labprefix."_DENR.xlsx"));
            default :
                $this->setDocument(IOFactory::load($this->location.$labprefix."_ISO.xlsx"));
        }       


       // Set cell A2 with a numeric value
        // $this->getDocument()->getActiveSheet()->setCellValue('A2', $this->template);

        $this->getDocument()->getActiveSheet()->setCellValue('C8', $this->template);
        $this->getDocument()->getActiveSheet()->setCellValue('C9', $this->template);
        $this->getDocument()->getActiveSheet()->setCellValue('C10', $this->template);
        $this->getDocument()->getActiveSheet()->setCellValue('C11', $this->template);
        $this->getDocument()->getActiveSheet()->setCellValue('C12', $this->location.$labprefix);

        // Parent::setDocument($document);
    }

     public function render()
    {
        //overrides the render so that it would do nothing with cdataactiveprovider
        return $this;
    }

}

?>