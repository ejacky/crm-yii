<?php
/**
 * Description of PropertyApi
 *
 * @author Marvin
 */
class CMSPropertyApi
{
	/**
	 *
	 * @param type $class
	 * @return CMSPropertyApi 
	 */
	public static function init($class = __CLASS__)
	{
		return new $class;
	}
	
	public function get($name, $topic)
	{
		$topicId = $this->getTopicId($topic);
		$model = Property::model()->findByAttributes(array('name' => $name, 'topic_id' => $topicId));
		if ($model)
		{
			return $model->value;
		}
		else
		{
			$this->getDefaultProperty($name);
		}
	}
	
	public function update($name, $topic, $value)
	{
		$topicId = $this->getTopicId($topic);
		$model = Property::model()->findByAttributes(array('nameSpace' => $name, 'topic_id' => $topicId));
		return Property::model()->updateByPk($model->id, array('title' => $value));
	}
	
	public function getDefaultProperty($name)
	{
		$defaultProperty = array(
			'cms-uploadFileType' => 'txt,jpg,php,png',
			'cms-uploadFileSize' => '1024',
			'cms-position' => '组长,副组长,工人',
		);
		
		if (isset($defaultProperty[$name]))
		{
			return $defaultProperty[$name];
		}
		else
		{
			return 'do not have a default property called '.$name;
		}
	}
	
	private function getTopicId($topic)
	{
		if (is_numeric($topic))
		{
			return $topic;
		}
		else
		{
			$topicIds = array(
				'auth' => 11,
			);

			if (isset($topicIds[$topic]))
			{
				return $topicIds[$topic];
			}
			else
			{
				return 'do not have a topic called '.$topic;
			}
		}
	}
}