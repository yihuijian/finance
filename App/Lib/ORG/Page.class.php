<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: Page.class.php 2712 2012-02-06 10:12:49Z liu21st $

class Page
{
	// 分页栏每页显示的页数
	public $rollPage = 5;
	// 页数跳转时要带的参数
	public $parameter;
	// 默认列表每页显示行数
	public $listRows = 20;
	// 起始行数
	public $firstRow;
	// 分页总页面数
	protected $totalPages;
	// 总行数
	protected $totalRows;
	// 当前页数
	protected $nowPage;
	// 分页的栏的总页数
	protected $coolPages;
	// 分页显示定制
	protected $config = array('header' => '条记录', 'prev' => '上一页',
							  'next' => '下一页', 'first' => '第一页',
							  'last' => '最后一页',
							  'theme' => ' <li><a>%totalRow% %header%</a></li> <li><a>%nowPage%/%totalPage% 页</a></li> %upPage% %linkPage% %downPage%');
	// 默认分页变量名
	protected $varPage;

	/**
	+----------------------------------------------------------
	 * 架构函数
	+----------------------------------------------------------
	 * @access public
	+----------------------------------------------------------
	 * @param array $totalRows  总的记录数
	 * @param array $listRows  每页显示记录数
	 * @param array $parameter  分页跳转的参数
	+----------------------------------------------------------
	 */
	public function __construct($totalRows, $listRows = '', $parameter = '')
	{
		$this->totalRows = $totalRows;
		$this->parameter = $parameter;
		$this->varPage = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
		if (!empty($listRows)) {
			$this->listRows = intval($listRows);
		}
		$this->totalPages = ceil($this->totalRows / $this->listRows); //总页数
		$this->coolPages = ceil($this->totalPages / $this->rollPage);
		$this->nowPage = !empty($_GET[$this->varPage]) ? intval($_GET[$this->varPage]) : 1;
		if (!empty($this->totalPages) && $this->nowPage > $this->totalPages) {
			$this->nowPage = $this->totalPages;
		}
		$this->firstRow = $this->listRows * ($this->nowPage - 1);
	}

	public function setConfig($name, $value)
	{
		if (isset($this->config[$name])) {
			$this->config[$name] = $value;
		}
	}

	/**
	+----------------------------------------------------------
	 * 分页显示输出
	+----------------------------------------------------------
	 * @access public
	+----------------------------------------------------------
	 */
	public function show()
	{
		if (0 == $this->totalRows) return '';
		$p = $this->varPage;
		$nowCoolPage = ceil($this->nowPage / $this->rollPage);
		$url = $_SERVER['REQUEST_URI'] . (strpos($_SERVER['REQUEST_URI'], '?') ? '' : "?") . $this->parameter;
		$parse = parse_url($url);
		if (isset($parse['query'])) {
			parse_str($parse['query'], $params);
			unset($params[$p]);
			$url = $parse['path'] . '?' . http_build_query($params);
		}
		//上下翻页字符串
		$upRow = $this->nowPage - 1;
		$downRow = $this->nowPage + 1;
		if ($upRow > 0) {
			$upPage = "<li><a href='" . $url . "&" . $p . "=$upRow'>" . $this->config['prev'] . "</a></li>";
		} else {
			$upPage = "<li class='disabled'><a>" . $this->config['prev'] . "</a></li>";
		}

		if ($downRow <= $this->totalPages) {
			$downPage = "<li><a href='" . $url . "&" . $p . "=$downRow'>" . $this->config['next'] . "</a></li>";
		} else {
			$downPage = "<li class='disabled'><a>" . $this->config['next'] . "</a></li>";
		}
		// 1 2 3 4 5
		$linkPage = "";
		for ($i = 1; $i <= $this->rollPage; $i++) {
			$page = ($nowCoolPage - 1) * $this->rollPage + $i;
			if ($page != $this->nowPage) {
				if ($page <= $this->totalPages) {
					$linkPage .= "<li><a href='" . $url . "&" . $p . "=$page'>" . $page . "</a></li>";
				} else {
					break;
				}
			} else {
				if ($this->totalPages != 1) {
					$linkPage .= "<li class='disabled'><a>" . $page . "</a></li>";
				}
			}
		}
		$pageStr = str_replace(
			array('%header%', '%nowPage%', '%totalRow%', '%totalPage%', '%upPage%', '%linkPage%', '%downPage%'),
			array($this->config['header'], $this->nowPage, $this->totalRows, $this->totalPages, $upPage, $linkPage, $downPage), $this->config['theme']);
		return $pageStr;
	}

}