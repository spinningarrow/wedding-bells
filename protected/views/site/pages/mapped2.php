<?php
Yii::import('ext.jquery-gmap.*');
// build a normal Yii form
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'address-form',
));
$address =  new Address();
echo $form->textField($address, 'latitude');
echo $form->textField($address, 'longitude');
//echo $form->textField($address, 'city');
 
// [etc ... etc ...]
 
// create a map centered in the middle of the world ...
$gmap = new EGmap3Widget();
$gmap->setOptions(array(
        'zoom' => 2,
        'center' => array(0,0),
));
// add a marker
$marker = new EGmap3Marker(array(
    'title' => 'Updateable marker',
));
$marker->latLng = array(0,0);
$gmap->add($marker);
 
// tell the gmap to update the marker from the Address model fields.
$gmap->updateMarkerAddressFromModel(
     // the model object
     $address,
     // the model attributes to capture, these MUST be present in the form
     // constructed above. Attributes must also be given in the correct
     // order for assembling the address string.
     array('latitude','longitude'),
     // you may pass these options :
     // 'first' - set to first marker added to map, default is last
     // 'nopan' - do not pan the map on marker update.
     array()
);
$gmap->renderMap();
?>
<?php $this->endWidget(); ?>