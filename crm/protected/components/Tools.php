<?php

class Tools {
	public static function getTableTitles() {
		return array(
			'attachment.size' => '文件大小',
			'attr' => '属性',
			'category' => '分类',
			'checkbox' => '<input type="checkbox" id="checkall"/>',
			'defaultValue' => '默认值',
			'explain' => '说明文字',
			'fileName_re' => '文件名称',
			'form_id' => '表单名',
			'id' => '序列号',
			'isEdit' => '是否可自定义',
			'isMust' => '是否必填',
			'label' => '标签',
			'name' => '名称',
			'nameSpace' => '命名空间',
			'operater' => '操作',
			'orderId' => '排序',
			'time' => '时间',
			'type' => '类型',
			'userName_re' => '上传者',
			/*
			 * about client
			 */

			'staff_id' => '负责员工',
			'task_id' => '联系记录',
			'sales_id' => '销售名称',
			'name' => '客户名称',
			'starLevel' => '客户等级',
			'simpleName' => '客户简称',
			'trade' => '行业',
			'companySize' => '客户规模',
			'majorProduct' => '主要产品',
			'address' => '地址',
			'phone' => '总机',
			'fax' => '传真',
			'webSite' => '网址',
			'introduction' => '客户简介',
			'companyAttach' => '客户附件',
			'email' => '客户邮箱',
			'founder' => '创始人',
			'createTime' => '创始时间',
			'clientSource' => '客户来源',
			'contactPerson' => '联系人',
			'date' => '日期',
			/*
			 * about contact
			 */
			'client_id' => '客户名称',
			'ename' => '英文名称',
			'department' => '部门',
			'position' => '职位',
			'mobilePhone' => '手机',
			'personalEmail' => '个人邮箱',
			'birthday' => '出生日期',
			'educational' => '学历',
			'workingYears' => '工作年限',
			'gender' => '性别',
			'qq' => 'QQ号码',
			'msn' => 'MSN号码',
			'skype' => 'SKYPE号码',
			'weiBo' => '新浪微博',
			'tQq' => '腾讯微博',
			'remark' => '备注',
			'staffPerson' => '负责员工',
			'clientName' => '客户名称',
			/*
			 * about course
			 */
			'lecturer_id' => '讲师',
			'contact_id' => '联系人名称',
			'followCourseId' => '跟课人',
			'courseName' => '课程名',
			'courseAddress' => '讲课地址',
			'courseTime' => '开课时间',
			'contactPhone' => '客户联系电话',
			'courseIntroduction' => '课程大纲',
			'courseHandOuts' => '课程讲义',
			'courseVideo' => '课程视频',
		);
	}
        
        public static function getModel2FormNames() {
                return array(
                        'PaForm' => 'newForm',
                        'PaField' => 'newField',
                        'Staff' => 'staff',
                        'Client' => 'client',
                        'TableModel' => 'coreTable',
                );
        }
        
        public static function getModel2FormName($modelName) {
                $formNames = self::getModel2FormNames();
                if (isset($formNames[$modelName])) {
                        return $formNames[$modelName];
                } else {
                        return '';
                }
        }

	public static function getController2Model() {
		return array(
			'client' => 'Company',
			'contact' => 'Contact',
			'assist' => 'null',
			'customForm' => array(
			'NewForm' => 'PaForm',
			'NewField' => 'PaField',
			),
		);
	}

	public static function getTableTitle($name) {
		$titles = self::getTableTitles();
		if (isset($titles[$name])) {
			return $titles[$name];
		} else {
			return '';
		}
	}

	public static function sizecount($filesize) {
		if ($filesize >= 1073741824) {
			$filesize = round($filesize / 1073741824 * 100) / 100 . ' G';
		} elseif ($filesize >= 1048576) {
			$filesize = round($filesize / 1048576 * 100) / 100 . ' M';
		} elseif ($filesize >= 1024) {
			$filesize = round($filesize / 1024 * 100) / 100 . ' K';
		} else {
			$filesize = $filesize . ' bytes';
		}
		return $filesize;
	}

	public static function getPagerInfo($rowsTotal, $atPage = 1, $rowsPerPage = 10, $displayPageAreaNum = 5) {
		$pageInfo['rowsTotal'] = $rowsTotal;

		$pageInfo['pageTotal'] = ceil($rowsTotal / $rowsPerPage);
		$pageInfo['pageAt'] = $atPage;

		if ($pageInfo['pageTotal'] <= $displayPageAreaNum) {
			$pageInfo['pageStart'] = 1;
			$pageInfo['pageEnd'] = $pageInfo['pageTotal'] ? $pageInfo['pageTotal'] : 1;
		} else if ($atPage - ceil($displayPageAreaNum / 2) <= 0) {
			$pageInfo['pageStart'] = 1;
			$pageInfo['pageEnd'] = $displayPageAreaNum;
		} else if ($pageInfo['pageTotal'] - $atPage <= ceil($displayPageAreaNum / 2)) {
			$pageInfo['pageStart'] = $pageInfo['pageTotal'] - $displayPageAreaNum + 1;
			$pageInfo['pageEnd'] = $pageInfo['pageTotal'];
		} else {
			$pageInfo['pageStart'] = $atPage - ceil($displayPageAreaNum / 2) + 1;
			$pageInfo['pageEnd'] = $pageInfo['pageStart'] + $displayPageAreaNum - 1;
		}

		$pageInfo['pageArea'] = range($pageInfo['pageStart'], $pageInfo['pageEnd']);

		$pageInfo['pageAtFirst'] = ($pageInfo['pageAt'] == 1 ? true : false);
		$pageInfo['pageAtLast'] = ($pageInfo['pageAt'] >= $pageInfo['pageTotal'] ? true : false);

		$pageInfo['pagePrevious'] = $pageInfo['pageAtFirst'] ? 1 : $pageInfo['pageAt'] - 1;
		$pageInfo['pageNext'] = $pageInfo['pageAtLast'] ? $pageInfo['pageEnd'] : $pageInfo['pageAt'] + 1;

		return $pageInfo;
	}

}

?>
