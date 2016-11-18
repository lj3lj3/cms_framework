<?php
/*
使用方法
require_once SWCMS_ROOT.'./include/page.class.php';
$sql = "SELECT * FROM table  ORDER BY id DESC"; //SQL查询语句.
$px = new Pagex();
$px->total = $db->num_rows($db->query($sql));
$query = $db->query($sql." LIMIT {$px->thispage},{$px->pagesize}");

echo $px->pageshow('default');
*/
class Pagex{
        public $total;    //记录总数
        public $pagename; //分页URL参数名称default:p;
        public $pagesize; //每页记录数default:10        
        public $pagelist; //显示数字页数default:0
        public $pageurl;  //链接URL
        public $pagetext; //显示分页相关信息
        public $thispage;
        
        //初始化函数
        function __construct($pagesize=10,$pagelist=10,$pagetext=true,$pagename='p'){
            // DayL mod
//          $this->total = intval(@$total);
          $this->pagesize = $pagesize;
          $this->pagename = $pagename;
            // DayL mod 添加默认
            if (!isset($_REQUEST[$this->pagename])) {
                $_REQUEST[$this->pagename] = 0;
            }
          $this->pagelist = $pagelist;          
          $this->pagetext = $pagetext;     
          $this->thispage = ($this->currpage()-1)*$this->pagesize;
         //URL处理===================================
           if(!$this->pageurl){$this->pageurl=$_SERVER["REQUEST_URI"];}
           $parse_url=parse_url($this->pageurl);
           @$url_query=$parse_url["query"]; 
             if($url_query){
               // DayL mod 缺定界符
//             @$url_query=ereg_replace("(^|&){$this->pagename}={$this->currpage()}","",@$url_query);
             @$url_query=preg_replace("/(^|&){$this->pagename}={$this->currpage()}/","",@$url_query);
             $this->pageurl=str_replace($parse_url["query"],$url_query,$this->pageurl);
               if($url_query) $this->pageurl.="&amp;".$this->pagename; else $this->pageurl.=$this->pagename;
             }else {
               $this->pageurl.="?".$this->pagename;
             }
         //URL处理结束=================================    
        }
        

       
        //获取当前页码
        function currpage(){
         $getpage = (@$_REQUEST[$this->pagename] + 0 <= 0)? 1: (@$_REQUEST[$this->pagename] + 0);
          if (!is_int($getpage)) {
              $getpage = 1;           
          }    
          return $getpage;       
        }
        //获取当前页码
        
        
        
        /*计算页数================================*/
        //最后一页
        function lastpage(){
             
            return intval((floor($this->total/$this->pagesize) == ceil($this->total/$this->pagesize))?floor($this->total/$this->pagesize):ceil($this->total/$this->pagesize));
          //return ceil($this->total/$this->pagesize); 
        }        
        //上一页
        function prevpage(){
          return $this->currpage()-1;
        }
        //下一页
        function nextpage(){
          return ($this->currpage()==$this->lastpage() || $this->lastpage()<1 ? 0 :$this->currpage()+1);
          //if ($this->currpage()==$this->lastpage())
        }
        /*计算结束================================*/
        
        //数字分页按扭
        function numberhtml($page){
           if($this->currpage()==$page){
            return "<a><em>[".$page."]</em></a>";
           }else{
            return "<a title=\"".$page."\" href=\"".$this->pageurl."=".$page."\"><em>[".$page."]</em></a>";
           }
        }
		//数字分页按扭
        function numberadmin($page){
            $nextlink = '';
           if($this->currpage()==$page){
            return "<li class=\"paginItem  current\"><a href=\"".$nextlink."\">".$page."</a></li>";
           }else{
            return "<li class=\"paginItem\"><a href=\"".$this->pageurl."=".$page."\">".$page."</a></li>";
           }
        }
        
        
        //计算生成数字分页导航条
        function pagelist(){
              if($this->pagelist>0){
                  $listhtml.= '';
                      if ($this->pagelist >= $this->lastpage()) {            
                          for ($i = 1; $i <= $this->lastpage(); $i++) {
                              $listhtml .= $this->numberhtml($i);
                          }
                      } else {
                          $ceilpage = ceil($this->pagelist/2);                       
                          if ($this->currPage() <= $ceilpage) {                
                              for ($i = 1; $i <= $this->pagelist; $i++) {
                                  $listhtml .= $this->numberhtml($i);
                              }
                          } else {
                              if ($this->currPage()+$ceilpage <= $this->lastpage()) {
                                  for($i=$this->currPage()-$ceilpage+1;$i<=$this->currPage()+$ceilpage;$i++){
                                      $listhtml .= $this->numberhtml($i);
                                  }
                              } else {
                                  for ($i = $this->lastpage()-$this->pagelist+1; $i <=$this->lastpage(); $i++) {
                                      $listhtml .= $this->numberhtml($i);
                                  }
                              }
                          }
                      }
                  $listhtml.= "";
                
                 return $listhtml;
                 
              }else{              
                return "&nbsp;";
              }
        }
		//计算生成数字分页导航条
        function pageadmin(){
              if($this->pagelist>0){
                  $listhtml = '';
                      if ($this->pagelist >= $this->lastpage()) {            
                          for ($i = 1; $i <= $this->lastpage(); $i++) {
                              $listhtml .= $this->numberadmin($i);
                          }
                      } else {
                          $ceilpage = ceil($this->pagelist/2);                       
                          if ($this->currPage() <= $ceilpage) {                
                              for ($i = 1; $i <= $this->pagelist; $i++) {
                                  $listhtml .= $this->numberadmin($i);
                              }
                          } else {
                              if ($this->currPage()+$ceilpage <= $this->lastpage()) {
                                  for($i=$this->currPage()-$ceilpage+1;$i<=$this->currPage()+$ceilpage;$i++){
                                      $listhtml .= $this->numberadmin($i);
                                  }
                              } else {
                                  for ($i = $this->lastpage()-$this->pagelist+1; $i <=$this->lastpage(); $i++) {
                                      $listhtml .= $this->numberadmin($i);
                                  }
                              }
                          }
                      }
                  $listhtml.= "";
                
                 return $listhtml;
                 
              }else{              
                return "&nbsp;";
              }
        }
        
        
        
//显示分页模块        
        function pageshow($pagetype){
          $pagehtml = '';
          
          $homelink = $this->pageurl."=1";
          $prevlink = $this->pageurl."=".$this->prevpage();
          $nextlink = $this->pageurl."=".$this->nextpage();
          $lastlink = $this->pageurl."=".$this->lastpage();

           switch($pagetype){              
                case "wap"://WAP分页系统。
                   if($this->prevpage()) {
                    $pagehtml.="<a href=\"".$homelink."\">首页</a>";
                    $pagehtml.="<a href=\"".$prevlink."\">上页</a>";                   
                   }                                 
                   if($this->nextpage()) {
                    $pagehtml.="<a href=\"".$nextlink."\">下页</a>";
                    $pagehtml.="<a href=\"".$lastlink."\">尾页</a>";
                   }
                   
                   if($this->total>=$this->pagesize){                   
                   $pagehtml.= "<br/>[第".$this->currpage()."/".$this->lastpage()."页|总".$this->total."条]<br/>";
                   $pagehtml.="<input name=\"p\" type=\"text\" maxlength=\"5\" size=\"1\" value=\"1\" emptyok=\"true\" />";
                   $pagehtml.="<anchor title=\"跳到\">跳到该页<go href=\"".$this->pageurl."=$(p)\" method=\"post\">";
                   $pagehtml.="<postfield name=\"p\" value=\"$(p)\" />";
                   $pagehtml.="</go></anchor>";
                   }
                break;
                
                case "style": //带样式化分页
                    $pagehtml.="<div class=\"px\">";
                  if($this->pagetext){
                    $pagehtml.="<span class=\"total\">总共".$this->total."记录</span>";
                   }
                   if($this->prevpage()) {
                    $pagehtml.="<span class=\"link\"><a href=\"".$homelink."\">首页</a></span>";
                    $pagehtml.="<span class=\"link\"><a href=\"".$prevlink."\">上一页</a></span>";
                   }else{
                    $pagehtml.="<span class=\"text\">首页</span>";
                    $pagehtml.="<span class=\"text\">上一页</span>";
                   }
                    
                    $pagehtml.=$this->pagelist();//数字分页导航条
                            
                   if($this->nextpage()) {
                    $pagehtml.="<span class=\"link\"><a href=\"".$nextlink."\">下一页</a></span>";
                    $pagehtml.="<span class=\"link\"><a href=\"".$lastlink."\">尾页</a></span>";
                   }else{
                    $pagehtml.="<span class=\"text\">下一页</span>";
                    $pagehtml.="<span class=\"text\">尾页</span>";
                   }
                  if($this->pagetext){
                    $pagehtml.="<span class=\"pages\">当前".$this->currpage()."/".$this->lastpage()."分页</span>";
                   }  
                    $pagehtml.="</div>";
                break;
				
				case "admin": //带样式化分页
                    
                  if($this->pagetext){
                    $pagehtml.="<div class=\"message\">共<i class=\"blue\">".$this->total."</i>条记录，当前显示第&nbsp;<i class=\"blue\">".$this->currpage()."</i>&nbsp;页</div>";
                   }
				   $pagehtml.="<ul class=\"paginList\">";
                   if($this->prevpage()) {
                    $pagehtml.="<li class=\"paginItem\"><a href=\"".$homelink."\">首页</a></li>";
                    $pagehtml.="<li class=\"paginItem\"><a href=\"".$prevlink."\"><span class=\"pagepre\"></span></a></li>";
                   }else{
                    $pagehtml.="<li class=\"paginItem\"><a>首页</a></li>";
                    $pagehtml.="<li class=\"paginItem\"><a><span class=\"pagepre\"></span></a></li>";
                   }
                    
                    $pagehtml.=$this->pageadmin();//数字分页导航条
                            
                   if($this->nextpage()) {
                    $pagehtml.="<li class=\"paginItem\"><a href=\"".$nextlink."\"><span class=\"pagenxt\"></span></a></li>";
                    $pagehtml.="<li class=\"paginItem\"><a href=\"".$lastlink."\">尾页</a></li>";
                   }else{
                    $pagehtml.="<li class=\"paginItem\"><a><span class=\"pagenxt\"></span></a></li>";
                    $pagehtml.="<li class=\"paginItem\"><a>尾页</a></li>";
                   }
                  if($this->pagetext){
                    $pagehtml.="<li class=\"paginItem\"><a>".$this->currpage()."/".$this->lastpage()."</a></li>";
                   }  
                   $pagehtml.="</ul>";
                break;
         
                default://默认分页形式。
                  if($this->pagetext){
                    $pagehtml.="<a><em>总共".$this->total."记录</em></a>";
                   }
                   if($this->prevpage()) {
                    $pagehtml.="<a href=\"".$homelink."\"><em>首页</em></a>";
                    $pagehtml.="<a href=\"".$prevlink."\"><em>上一页</em></a>";
                   }else{
                    $pagehtml.="<a><em>首页</em></a>";
                    $pagehtml.="<a><em>上一页</em></a>";
                   }
                    
                    $pagehtml.=$this->pagelist();//数字分页导航条
                            
                   if($this->nextpage()) {
				   	$pagehtml.="<a href=\"".$nextlink."\"><em>下一页</em></a>";
                    $pagehtml.="<a href=\"".$lastlink."\"><em>尾页</em></a>";
                   }else{
				   	$pagehtml.="<a><em>下一页</em></a>";
                    $pagehtml.="<a><em>尾页</em></a>";
                   }
                  if($this->pagetext){
                    $pagehtml.="<a><em>当前".$this->currpage()."/".$this->lastpage()."总页</em></a>";
                   }                   
           }                   
         return $pagehtml;     
        }
//显示页面结束              
}