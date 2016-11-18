<?php
	class Pagebr {
		private $total; //数据表中总记录数
		private $listRows; //每页显示行数
		private $limit;
		private $uri;
		private $pageNum; //页数
		//public $html="";
/*		private $config=array('header'=>"Histórico", "prev"=>"Página anterior", "next"=>"Próxima pagina", "first"=>"Página inicial", "last"=>"Ultima pagina
");
*/
		private $config=array('header'=>"第", "prev"=>"Anterior", "next"=>"Próxima", "first"=>"Primeira", "last"=>"Última");
		private $listNum=8; //显示几个快速的链接，详情请看成品效果。
		/*
		 * $total 
		 * $listRows
		 */
		public function __construct($total, $listRows=10, $pa="",$lang=''){
			$this->total=$total;
			$this->listRows=$listRows;
			$this->uri=$this->getUri($pa);
                        if($lang=='zh'){
                            $this->config = array('header'=>"第", "prev"=>"上一页", "next"=>"下一页", "first"=>"第一页", "last"=>"最后一页");
                        }
			$this->page=!empty($_GET["page"]) ? $_GET["page"] : 1;
			$this->pageNum=ceil($this->total/$this->listRows);
                        if($this->pageNum==0){
                            $this->pageNum = 1;
                        }
			$this->limit=$this->setLimit();
		}

		private function setLimit(){	//构建一个limit语句段（sql查询中要用到）
			return "Limit ".($this->page-1)*$this->listRows.", {$this->listRows}";
		}

		private function getUri($pa){
			$url=$_SERVER["REQUEST_URI"].(strpos($_SERVER["REQUEST_URI"], '?')?'':"?").$pa;
			//echo $url;       strpos() 函数返回字符串在另一个字符串中第一次出现的位置。
			$parse=parse_url($url);		//parse_url -- 解析 URL，返回其组成部分

		

			if(isset($parse["query"])){
				parse_str($parse['query'],$params);		//parse_str() 函数把查询字符串解析到变量中。把前者放到后者数组中
				unset($params["page"]);		//把$params["page"]这个变量重置
				$url=$parse['path'].'?'.http_build_query($params);
				
				//http_build_query -- 生成 url-encoded 之后的请求字符串
				
				
			}

			return $url;
		}

		//private function __get($args){
		function __get($args){
			if($args=="limit")
				return $this->limit;
			else
				return null;
		}

		private function start(){
			if($this->total==0)
				return 0;
			else
				return ($this->page-1)*$this->listRows+1;
		}

		private function end(){
			return min($this->page*$this->listRows,$this->total);
		}

		private function first(){
			$html='';
			if($this->page==1)
				$html.='';
			else
				$html.="&nbsp;<a href='{$this->uri}&page=1#ly'>{$this->config["first"]}</a>&nbsp;";

			return $html;
		}

		private function prev(){
			$html='';
			if($this->page==1)
				$html.='';
			else
				$html.="&nbsp;<a href='{$this->uri}&page=".($this->page-1)."#ly'>{$this->config["prev"]}</a>&nbsp;";

			return $html;
		}

		private function pageList(){
			$linkPage="";
			
			$inum=floor($this->listNum/2);
		
			for($i=$inum; $i>=1; $i--){
				$page=$this->page-$i;

				if($page<1)
					continue;

				$linkPage.="&nbsp;<a href='{$this->uri}&page={$page}#ly'>{$page}</a>&nbsp;";

			}
		
			$linkPage.="&nbsp;{$this->page}&nbsp;";
			

			for($i=1; $i<=$inum; $i++){
				$page=$this->page+$i;
				if($page<=$this->pageNum)
					$linkPage.="&nbsp;<a href='{$this->uri}&page={$page}#ly'>{$page}</a>&nbsp;";
				else
					break;
			}

			return $linkPage;
		}

		private function next(){
			$html='';
			if($this->page==$this->pageNum)
				$html.='';
			else
				$html.="&nbsp;<a href='{$this->uri}&page=".($this->page+1)."#ly'>{$this->config["next"]}</a>&nbsp;";

			return $html;
		}

		private function last(){
			$html='';
			if($this->page==$this->pageNum)
				$html.='';
			else
				$html.="&nbsp;<a href='{$this->uri}&page=".($this->pageNum)."#ly'>{$this->config["last"]}</a>&nbsp;";

			return $html;
		}

		private function goPage(){
			return '&nbsp;<input type="text" onkeydown="javascript:if(event.keyCode==13){var page=(this.value>'.$this->pageNum.')?'.$this->pageNum.':this.value;location=\''.$this->uri.'&page=\'+page+\'#ly\'}" value="'.$this->page.'" style="width:25px"><input type="button" value="GO" onclick="javascript:var page=(this.previousSibling.value>'.$this->pageNum.')?'.$this->pageNum.':this.previousSibling.value;location=\''.$this->uri.'&page=\'+page+\'#ly\'">';
		}
		public function fpage($display=array(0,1,2,3,4,5,6,7)){		//在这里修改$display可以影响里面的foreach函数的效果
			//$html[0]="&nbsp;Total&nbsp;<b>{$this->total}</b>&nbsp;{$this->config["header"]}&nbsp;";
			//$html[1]="&nbsp;&nbsp;exibir&nbsp;<b>".($this->end()-$this->start()+1)."</b>&nbsp;em cada pagina，Esta páginas tem&nbsp;<b>{$this->start()}-{$this->end()}</b>&nbsp;&nbsp;";
			//$html[1]="&nbsp;<b>{$this->page}/{$this->pageNum}</b>&nbsp;Páginas&nbsp;";
			$html[0]='总计 '.$this->total.' 条，';
			$html[1]="&nbsp;<b><a>{$this->page}/{$this->pageNum}</a></b>";
			$html[2]=$this->first();
			$html[3]=$this->prev();
			$html[4]=$this->pageList();
			$html[5]=$this->next();
			$html[6]=$this->last();
			$html[7]=$this->goPage();
			$fpage='';
                        foreach($display as $index){
                                
                                $fpage.=$html[$index];
                        }

			return $fpage;

		}

	
	}
