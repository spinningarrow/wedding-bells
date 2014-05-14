<?php
// init the model (usually passed to view)
Yii::import('ext.jquery-gmap.*');
$address = new Address();

// init the map
$gmap = new EGmap3Widget();
$gmap->setOptions(array('zoom' => 12));
 
// create the marker
$marker = new EGmap3Marker(array(
    'title' => 'Draggable address marker',
    'draggable' => true,
));
$marker->address = 'Singapore,Singapore';
$marker->centerOnMap();
 
// set the marker to relay its position information a model
$marker->capturePosition(
     // the model object
     $address,
     // model's latitude property name
     'latitude',
     // model's longitude property name
     'longitude',
     // Options set :
     //   show the fields, defaults to hidden fields
     //   update the fields during the marker drag event
     array('visible','drag')
);
$gmap->add($marker);
 
// Capture the map's zoom level, by default generates a hidden field
// for passing the value through POST
$gmap->map->captureZoom(
    // model object
    $address,
    // model attribute
   'mapZoomLevel',
   // whether to auto generate the field
   true,
   // HTML options to pass to the field
   array('class' => 'myCustomClass')
);
 
$gmap->renderMap();
// build a normal Yii form
/*$form = $this->beginWidget('CActiveForm', array(
    'id'=>'address-form',
));
echo $form->textField($address, 'longitude');
echo $form->textField($address, 'latitude');
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
     array('longitude','latitude'),
     // you may pass these options :
     // 'first' - set to first marker added to map, default is last
     // 'nopan' - do not pan the map on marker update.
     array()
);
$gmap->renderMap();
*/?>