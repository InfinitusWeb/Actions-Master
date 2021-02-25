<?php
/* Classe iwActions
	Classe para criação de botões de ação nas linhas de uma Grid Scriptcase
	Autor: Haroldo B Passos / InfinitusWeb
	Copyrirght: 2020 / 2020 Versão: 1.00.004 
	Fase II : Versão Beta Teste 21/05/2020 1.0.08 ...
*/

class IWActions
{
	private $lineSeq;
	private $item = '';
	private $id = 0;
	private $condition = TRUE;
	private $imageHeight = 20;
	private $pathImage;
	private $pathAction;
	private $itemSpace = '2';
	private $color = '';
	private $textStyle = '';
	private $text = false;
	private $toolBar = [];
	private $borderBottom = false;
	private $toolTip = false;
	private $itemSeparator = "<div Style ='float: left; display: inline-block;padding-right: 2px'></div>";
	private $link = '';
	private $modal = false;
	private $modalStyle = 'max-width: 80%; width: 40%; background: rgb(0, 0, 0); padding: 5px; text-align: center; height: 80%';
	private $cursor = '';
	private $toolTipWordWrap =  false;
	private $onClick = '';

	function __construct($lineSeq = 0)
	{
		$this->lineSeq = $lineSeq;
		$dirs = $this->recursiveDir('../_lib/libraries');
		foreach ($dirs as $path) {
			$pos = strpos($path, 'actions-master');
			if (is_numeric($pos)) {
				break;
			}
		}
		$path = substr($path, 0,  $pos - 1);
		$this->pathImage = $path . '/img';
		$this->pathAction = $path . '/actions-master';
	}

	public function setItemSpace($itemSpace)
	{
		$this->itemSpace = $itemSpace;
		$this->itemSeparator = "<div Style ='display: inline-block;padding-right:{$this->itemSpace}px'></div>";
	}

	public function setSeparator($flag = 'light')
	{
		if ($flag) {
			$space = $this->itemSpace / 2;
			$image = $flag === 'dark' ? 'separator-dark.png' : 'separator-light.png';
			$this->itemSeparator = "<div Style = 'display: inline-block;'><img src='{$this->pathAction}/img/$image' height='{$this->imageHeight}px' style='padding: 0px {$space}px;' /></div>";
		} else {
			$this->itemSeparator = "<div Style ='display: inline-block;padding-right: {$this->itemSpace}px'></div>";
		}
	}

	public function setBorderBottom()
	{
		$this->borderBottom = true;
	}

	public function setImageHeight($imageHeight)
	{
		$this->imageHeight = $imageHeight;
	}


	//size: w3-tiny, w3-small, w3-large, w3-xlarge, w3-xxlarge, w3-xxxlarge, w3-jumbo
	//color e hover:  hover-cor  baseado em https://www.w3schools.com/w3css/w3css_color_material.asp
	//tag | buble ou badges | RoadSings
	//RoadSings para Tag style padding
	//tag style transform:rotate(-5deg)
	//class padding,padding-small, padding-large

	public function setTag($type = 'tag', $class = '', $style = '')
	{
		$this->tagType = $type;
		$this->tagClass = $class;
		$this->tagStyle = $style;
	}

	public function setCondition($condition)
	{
		$this->condition = $condition;
	}

	public function setColor($colorTrue, $colorFalse = '')
	{
		$this->color = ($this->condition) ? $colorTrue : $colorFalse;
	}

	public function setSCImage($imgTrue, $categTrue = 'grp,img', $imgFalse = '', $categFalse = '')
	{
		if ($this->condition) {
			$categ = explode(',', $categTrue);
			$image = $imgTrue;
		} else {
			$categ = empty($categFalse) ? explode(',', $categTrue) : explode(',', $categFalse);
			$image = $imgFalse;
		}
		if ($image) {
			$categ[0] =  strtolower($categ[0]) == 'prj' ? 'grp' : strtolower($categ[0]);
			$image = $categ[0] . '__NM__' . strtolower($categ[1]) . '__NM__' . $image;
			$this->item = "<img src='../_lib/img/$image' height='{$this->imageHeight}px'/>";
		}
	}

	public function setImage($imageTrue, $imageFalse = '')
	{
		$path = $this->pathImage . '/';
		$image = ($this->condition) ? $imageTrue : $imageFalse;
		if ($image) {
			$this->item = "<img src='$path{$image}'  height='{$this->imageHeight}px' />";
		}
	}

	public function setAwesome($fontAwesomeTrue, $fontAwesomeFalse = '')
	{
		$fontAwesome = ($this->condition) ? $fontAwesomeTrue : $fontAwesomeFalse;
		$color = ($this->color) ? 'color: ' . $this->color : '';
		$this->item  = "<span style='font-size:{$this->imageHeight}px;$color;'><i class='$fontAwesome'></i></span>";
	}

	public function setTextStyle($styleTrue, $styleFalse = '')
	{
		$this->textStyle = ($this->condition) ? $this->parsToStyle($styleTrue) : $this->parsToStyle($styleFalse);
	}

	public function setText($textTrue, $textFalse = '')
	{
		$this->text = true;
		$this->item = ($this->condition) ? $textTrue : $textFalse;
	}

	public function setLink($linkTrue, $linkFalse = '')
	{
		$this->link = ($this->condition) ? $linkTrue : $linkFalse;
	}

	public function setModal($flag = true)
	{
		$this->modal = $flag;
	}

	public function setModalStyle($value = '')
	{
		$p = $this->parsToObj($value, 'maxWidth=80%, width=40%,background=#000,padding=5px,textAlign=center,height=80%');
		$this->modalStyle = "max-width: {$p->maxWidth}; width:{$p->width};height:{$p->height};background:{$p->background};padding:{$p->padding};text-align:{$p->textAlign}";
		$this->modal = true;
	}

	public function setCursor($cursorTrue = 'default', $cursorFalse = '')
	{
		$cursor = $this->condition ? $cursorTrue : $cursorFalse;
		$cursor = ($cursor) ? 'cursor:' . $cursor : '';
		if ($cursor) $this->cursor = $cursor;
	}

	public function setToolTipBottom()
	{
		$this->toolTip[1] = 'tooltiptext_bottom';
	}
	public function setToolTipLeft()
	{
		$this->toolTip[1] = 'tooltiptext_left';
	}

	public function setToolTipWordWrap($nChars = false)
	{
		$this->toolTipWordWrap = $nChars;
	}

	public function setToolTip($hintTrue, $hintFalse = '')
	{
		$this->toolTip[1] = (isset($this->toolTip[1])) ? $this->toolTip[1] : 'tooltiptext';
		$hint = ($this->condition) ? $hintTrue : $hintFalse;
		$this->toolTip[0] = $hint;
	}

	public function setOnClick($onClick)
	{
		$this->onClick = $onClick;
	}
	public function close()
	{
		$borderBottom = ($this->borderBottom) ? ' borderBottom' : '';

		if ($this->onClick) {
			$this->onClick = ' onclick = ' . $this->onClick;
		}

		if ($this->text) {
			$style = $this->textStyle;
			$color = ($this->color) && strpos($style, 'color') === false ? "color: {$this->color};" : '';
			$style = ($color || $style) ? "$style{$color}" : '';
			$class = ($this->borderBottom) ? "class=$borderBottom" : '';
			$this->item =  "<span  $class {$this->onClick} $style>{$this->item}</span>";
			$borderBottom = $borderBottom ?: '';
		}

		if ($this->link) {
			if ($this->modal) {
				$a = "href='#modal-form' onmouseup=\"modalStyle('{$this->modalStyle}');modalIframeSrc('{$this->link}');\"  "; //rel=modal:open
			} else {
				$a = "href='{$this->link}'";
			}
			$this->item = "<a class='action-link{$borderBottom}' $a>{$this->item}</a>";
			$borderBottom = $borderBottom ?: '';
		}

		if ($this->toolTip[0]) {
			//$style = "style = 'float: left; {$this->cursor}'";
			$style = "Style = '{$this->cursor}'";
			$this->toolTip[0] = ($this->toolTipWordWrap) ? wordwrap($this->toolTip[0], $this->toolTipWordWrap, "<br/>\n") : $this->toolTip[0];
			$this->item = "<div class='tooltip' {$this->onClick} $style>{$this->item}<span class='{$this->toolTip[1]}'>{$this->toolTip[0]}</span></div>";
		} else {
			//$style = "style = 'float: left; display: inline-block;{$this->cursor}'";
			$style = "Style = 'display: inline-block;{$this->cursor}'";
			$class = ($this->borderBottom) ? "class=$borderBottom" : '';
			$this->item = "<div $class {$this->onClick} $style>{$this->item}</div>";
		}

		$this->toolBar[$this->id] = $this->item;
		$this->id++;
		$this->setReset();
	}

	private function setReset($total = false)
	{
		$this->link = '';
		$this->cursor = '';
		$this->color = '';
		$this->textStyle = '';
		$this->text = false;
		$this->toolTip = false;
		$this->borderBottom = false;
		$this->modal = false;
		$this->modalStyle = 'max-width: 80%; width: 40%; background: rgb(0, 0, 0); padding: 5px; text-align: center; height: 80%';
		$this->item = '';
		$this->toolTipWordWrap =  false;
		$this->onClick = '';

		if ($total) {
			$this->id = 0;
			$this->condition = TRUE;
			$this->imageHeight = 20;
			$this->itemSpace = '2';
			$this->toolBar = [];
			$this->separator = false;
			$this->itemSeparator = '';
		}
	}

	public function createToolBar()
	{
		$html = '';
		foreach ($this->toolBar as $key => $value) {
			$strip_tags = trim(strip_tags($value, '<img><i>'));
			$value = ($strip_tags) ? $value : '';
			$html .= ($key > 0 && !empty($value)) ? $this->itemSeparator . $value : $value;
		}
		$this->setReset(true);
		return $html;
	}

	public function create()
	{
		return $this->createToolBar();
	}

	public function getPathAction()
	{
		return $this->pathAction;
	}

	//By Anton Backer 2006 get_leaf_dirs($dir) 
	private function recursiveDir($dir)
	{
		$array = array();
		$d = dir($dir);
		while (false !== ($entry = $d->read())) {
			if ($entry != '.' && $entry != '..') {
				$entry = $dir . '/' . $entry;
				if (is_dir($entry)) {
					$subdirs = $this->recursiveDir($entry);
					if ($subdirs)
						$array = array_merge($array, $subdirs);
					else
						$array[] = $entry;
				}
			}
		}
		$d->close();
		return $array;
	}

	private function parsToStyle($style)
	{
		$style = "style='" . str_replace(['=', ','], [':', ';'], $style) . "'";
		return $style;
	}

	//Método Mágico -> permite utilizar parametros nomeados nos demais métodos da classe
	//By Haroldo
	private function parsToObj($pars, $default)
	{
		$pars = !empty($pars) ? explode(',', $pars) : [];
		$res = [];
		foreach ($pars as $value) {
			$arr = explode('=', $value);
			if (is_numeric(strpos($arr[0], '-'))) {
				$atr = explode('-', $arr[0]);
				$arr[0] = $atr[0] . ucfirst($atr[1]);
			}
			$arr[0] = trim($arr[0]);
			$arr[1] = trim($arr[1]);
			if (strpos($arr[1], ';')) {
				$arr[1] = explode(';', $arr[1]);
			}
			$res[$arr[0]] = $arr[1];
		}
		$pars = $res;
		$res = [];
		$default = explode(',', $default);
		foreach ($default as $value) {
			$arr = explode('=', $value);
			$arr[0] = trim($arr[0]);
			$arr[1] = trim($arr[1]);
			if (strpos($arr[1], ';')) {
				$arr[1] = explode(';', $arr[1]);
			}
			$res[$arr[0]] = $arr[1];
		}
		$json = json_encode(array_merge($res, $pars));
		return json_decode($json);
	}
}
