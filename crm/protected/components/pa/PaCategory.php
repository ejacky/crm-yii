<?php

class PaCategory extends CoBase
{
	/**
	 *
	 * @param type $className
	 * @return CoCategory 
	 */
	public static function init($className=__CLASS__)
	{
		return new $className;
	}
	
	public $errors = array(
		1 => '该分类已经存在',
		2 => '该分类保存了数据，所以不能被删除',
		3 => '该分类存在子分类，所以不能被删除',
	);
		
	/**
	 *
	 * 保存一个分类
	 * 
	 * @param type $topicId
	 * @param type $name
	 * @param type $fatherId
	 * @return type 
	 */
		public function save($nameSpace, $name, $fatherId = 0)
		{
			if ($fatherId)
			{
				$father = $this->getModelById($fatherId);
				$myLevel = $father->level + 1;

				$sons = $this->getSons($fatherId);

				foreach ($sons as $son)
				{
					if ($son->name == $name)
					{
						return $this->error(1, array('name' => $name));
					}
				}
				
				$fullName = $father->full_name.'-'.$name;
			}
			else
			{
				$myLevel = 1;
				$fullName = $name;
			}

			$category = new Category();
			$category->user_id = Yii::app()->user->id;
			//$category->org_id = Yii::app()->user->orgId;
			$category->name_space = $nameSpace;
			$category->name = $name;
			$category->full_name = $fullName;
			$category->weight = 0;
			$category->father_id = $fatherId;
			$category->level = $myLevel;
			$category->tail = true;
			$category->save();

			if (isset($father) && $father->tail = true)
			{
				$father->tail = false;
				$father->save();
			}
			
			return $this->success('数据保存成功', array('id' => $category->id));
		}
	
	/**
	 *
	 * 获取某一个topic的所有分类
	 * @param type $id
	 * @return type 
	 */
	public function getAll($nameSpace)
	{
		$categories = Category::model()->findAll(array('condition' => 'name_space = :name_space', 'params' => array(':name_space' => $nameSpace), 'order' => 'level, weight DESC'));
	
		// 排序取得合适的显示排序
		$returnCategories = array();
		foreach($categories as $category)
		{
			if ($category->level == 1)
			{
				$returnCategories[] = $category;
				
				$returnCategories = array_merge($returnCategories, $this->getAllSubLevelCategory($category->id, $categories, false));
			}
		}

		return $returnCategories;
	}
	
	/**
	 *
	 * 更新某个分类的值
	 * @param type $nameSpace
	 * @param type $id
	 * @param type $data 
	 * @todo 不能调整为自己的一个下级分类为自己的上级分类
	 */
	public function updateCategory($id, $data = array())
	{
		$category = new Category;
		$category->updateByPk($id, $data);
	}
	
	/**
	 *
	 * 删除某个分类
	 * @param type $nameSpace
	 * @param type $id
	 * @return type 
	 */
	public function deleteCategory($id)
	{
		$category = Category::model()->findByPk($id);
		if ($category->item != 0)
		{
			return $this->error(2);
		}
		
		if ($this->getSons($id))
		{
			return $this->error(3);
		}

		if ($category->father_id)
		{
			$sons = $this->getSons($category->father_id);
			if (count($sons) == 1)
			{
				$father = $this->getModelById($category->father_id);
				$father->tail = true;
				$father->save();
			}
		}
		
		$category->delete();
		
		return $this->success('删除成功');
	}

	/**
	 *
	 * 为分类添加一个统计项
	 * @param type $id
	 * @param type $number 
	 */
	public function addItem($id, $number = 1)
	{
		$category = Category::model()->findByPk($id, array('condition' => 'name_space = :name_space', 'params' => array(':name_space' => $nameSpace)));
		$category->item += $number;
		
		$category->update();
	}
	
	/**
	 * 为分类添减一个统计项
	 * @param type $id
	 * @param type $number 
	 */
	public function reduceItem($id, $number = -1)
	{
		$category = Category::model()->findByPk($id, array('condition' => 'name_space = :name_space', 'params' => array(':name_space' => $nameSpace)));
		$category->item += $number;
		
		$category->update();
	}
	
	// 递归排序获得分类的正确顺序
	private function getAllSubLevelCategory($id, $categories, $returnTree = true)
	{
		$temp = array();
		foreach ($categories as $key => $category)
		{
			if ($category->father_id == $id)
			{
				if ($returnTree)
				{
					$temp[] = array('model' => $category, 'children' => $this->getAllSubLevelCategory($category->id, $categories, $returnTree));
				}
				else
				{
					$temp[] = $category;
					$temp += array_merge($temp, $this->getAllSubLevelCategory($category->id, $categories, $returnTree));
				}
			}
		}

		return $temp;
	}
	
	/**
	 *
	 * 根据Id返回一个model
	 * @param type $id
	 * @return type 
	 */
	public function getModelById($id)
	{
		return Category::model()->findByPk($id);
	}
	
	/**
	 *
	 * 返回某一个level的所有model
	 * @param type $level
	 * @param type $topicId
	 * @return type 
	 */
	public function getSons($id)
	{
		return Category::model()->findAll(array('condition' => 'father_id = :father_id', 'params' => array(':father_id' => $id)));
	}
	
	public function getTree($nameSpace)
	{
		$categories = Category::model()->findAll(array('condition' => 'name_space = :name_space and org_id = :orgId', 'params' => array(':name_space' => $nameSpace, ':orgId' => Yii::app()->user->orgId), 'order' => 'level, weight DESC'));

		return $this->sortForJsTree($categories);
	}
	
	public function sortForJsTree($categories)
	{
		$data = array();
		foreach($categories as $category)
		{
			if ($category->level == 1)
			{
				$data[] = array('model' => $category, 'children' => $this->getAllSubLevelCategory($category->id, $categories));
			}
		}
		
		return $data;
	}
	
	public function getInfoForTreeJsonData($nameSpace)
	{
		$data = array('data' => $this->convertToJsTreeFormat($nameSpace, $this->getTree($nameSpace)));
		return json_encode($data);
	}
	
	protected function convertToJsTreeFormat($nameSpace, $categories)
	{
		$data = array();
		foreach ($categories as $category)
		{
			$array = array();
			$array['data'] = $category['model']->name;
			$array['metadata'] = array("id" => $category['model']->id, "name" => $category['model']->name);
			$array['children'] = $this->convertToJsTreeFormat($nameSpace, $category['children']);
			$array['attr']['id'] = $nameSpace.$category['model']->id;
			if (!$array['children'])
			{
				$array['attr']['rel'] = 'tail';
			}
			
			$data[] = $array;
		}

		return $data;
	}
}
?>
