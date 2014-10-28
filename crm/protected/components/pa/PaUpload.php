<?php

/**
 *
 * 分类系统
 * 业务层实现
 * @author sam sam@ozzyad.com
 *
 */
class  PaUpload
{
	private  $category;
	public function __construct($categoryId)
	{
		$this->categoryId = $categoryId;
	}

	/**
	 *
	 * 创建分类检测
	 * 分类下有文件不能创建分类
	 */
	public function creategetCategory($categoryId)
	{
		$file = $this->getFile();
		if (!empty($file)){
			return $this->returnMsg("分类创建失败!,该目录下有其他文件.", 1);
		}
		return $this->returnMsg("创建成功");
	}

	/**
	 *
	 * 上传文件检测
	 * 分类下有分类不能创建文件
	 */
	public function fileUploadCheck()
	{
		$category = $this->getCategory();
		if (!empty($category)){
			return $this->returnMsg("文件上传失败!,该目录下有其他分类.", 1);
		}
		return $this->returnMsg("上传成功");
	}

	/**
	 *
	 * 删除分类
	 */
	public function deleteCategory()
	{
		$file = $this->getFile();
		if (!empty($file)){
			return $this->returnMsg("分类删除失败!,该分类下有其他文件,请确认.", 1);
		}
		$category = $this->getCategory();
		if (!empty($category)){
			return $this->returnMsg("分类删除失败!,该分类下有其他分类,请确认.", 1);
		}
		Category::model()->delete('id=:Id',array(':Id'=>$this->category));
		return $this->returnMsg("删除成功!");
	}

	/**
	 * 删除文件
	 */
	public function deleteFile()
	{
		$result = File::model()->findByPk($this->categoryId);
		$miniatt = new PaAttachment();
		$miniatt->deleteById($result->attachment_id);
		$result->delete();
		return $this->returnMsg("删除成功!");
	}


	/**
	 *
	 * 检测分类下是否有文件, 并返回
	 */
	public function getFile()
	{
		return File::model()->findAll(array(
			'condition'=>'category_id = :id',
		    'params'=>array(':id'=>$this->categoryId
		)));
	}

	/**
	 *
	 * 检测分类下是否有子分类, 并返回
	 */
	public function getCategory()
	{
		return PaCategory::init()->getSons($this->categoryId) ;
	}

	/**
	 *
	 * 返回信息
	 * @param string $message
	 * @param int $errorNumber
	 */
	private function returnMsg( $message, $errorNumber=0 )
	{
		return array('error' => $errorNumber, 'message' => $message);
	}


	/**
	 *
	 * 通过file表id获取attachment  model
	 * @param int $id
	 */
	public function getAttachmentById($id)
	{
		$result = File::model()->findByPk($id);
		$miniatt = new PaAttachment();
		$attachment = $miniatt->getModelById($result->attachment_id);
		return $attachment;
	}

}