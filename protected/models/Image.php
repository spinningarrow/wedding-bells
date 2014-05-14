<?php 
class Image extends CFormModel
{
	public $image;
	public function rules()
	{
		return array(
			array('image','file','types'=>'jpg,jpeg','wrongType'=>'Only files of type .jpg or .jpeg are allowed','maxSize' => 80*1024,'tooLarge' => 'The file was larger than 80KB. Please upload a smaller file.','allowEmpty'=>true ),
			array('image','required','on'=>'create'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
		);
	}
}
?>
