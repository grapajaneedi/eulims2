<?php

namespace yii2tech\spreadsheet;

use yii2tech\spreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;


 /**
* 
*/
class Myspreadsheet extends Spreadsheet
{

	/**
     * @var location the data provider for the view. This property is required.
     */
	public $location="";
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
    	 // $location = \Yii::$app->basePath.'\\modules\\reports\\modules\\lab\\templates\\';
    	// echo $this->location; exit;
        //$this->_document = $document;
        // $this->_document = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
        
        $this->setDocument(IOFactory::load($this->location."CHEM_ISO.xlsx"));
        // Parent::setDocument($document);
    }

}

?>