// JavaScript Document
function nTabs(thisObj,Num){
if(thisObj.className == "on")return;
var tabObj = thisObj.parentNode.id;
var tabList = document.getElementById(tabObj).getElementsByTagName("li");
for(i=0; i <tabList.length; i++)
{
  if (i == Num)
  {
	  thisObj.className = "on"; 
      document.getElementById(tabObj+"_Content"+i).style.display = "block";
  }else{
		tabList[i].className = ""; 
		document.getElementById(tabObj+"_Content"+i).style.display = "none";
  }
} 
}


function tab_menu_show(sid,x,sum,inm,csnama)
{
for (i=1;i<=sum;i++){document.getElementById(sid+'_'+i).className="";document.getElementById(inm+'_'+i).style.display="none";}
document.getElementById(sid+'_'+x).className=csnama;
document.getElementById(inm+'_'+x).style.display="block";
}


