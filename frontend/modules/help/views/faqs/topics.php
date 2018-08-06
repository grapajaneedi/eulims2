<?php
use dosamigos\gallery\Carousel;

$this->title = 'FAQs';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $items = [
    [
        'title' => 'Step 1',
        'href' => '/uploads/faqs/create-request/1.png',
        'type' => 'png',
        
    ],
    [
       'title' => 'Step 2',
       'href' => '/uploads/faqs/create-request/2.png',
       'type' => 'png',
    ],
    
];?>
<?= dosamigos\gallery\Carousel::widget([
    'items' => $items, 'json' => true,
    'options'=>[
        'disableScroll'=>true,
    ],
    'clientEvents' => [
        'onslide' => 'function(index, slide) {
            console.log(slide);
        }'
]]);
