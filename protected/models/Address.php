<?php
class Address extends CActiveRecord
{
    public $latitude;
    public $longitude;
        public $mapZoomLevel;
 
    public function rules()
    {
            return array(
                array('latitude,longitude', 'numerical'),
                array('mapZoomLevel', 'numerical', 'integerOnly'=>true),
            );
    }
} ?>
