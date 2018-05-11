<?php

namespace common\components;


class GooglePlacesAutoComplete {

    $API_URL = '//maps.googleapis.com/maps/api/js?';
    
    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript(){
        $elementId = $this->options['id'];
        $scriptOptions = json_encode($this->autocompleteOptions);
        $view = $this->getView();
        //$view->registerJsFile(self::API_URL . http_build_query([
        //    'key'=>\Yii::$app->places->key,
        //    'libraries' => $this->libraries,
        //    'language' => $this->language
        //]));
        $view->registerJs(<<<JS
(function(){
    var input = document.getElementById('{$elementId}');
    var options = {$scriptOptions};
    autocomplete=new google.maps.places.Autocomplete(input, options);
    autocomplete.addListener('place_changed', fillInAddress);
})();
JS
        , \yii\web\View::POS_READY);
    }
}
