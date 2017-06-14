/******************************************************************************
 * pre.js
 *
 * Program      Javascript関数ライブラリ
 * Date         2003-02-07
 *
 * @package     prebit/admin
 * @access      public
 * @author      kenji kimura
 * @version     $Id: pre.js,v 1.16 2012/01/20 06:03:49 iauc Exp $
 *
 */
/******************************************************************************/

var SID;                    // セッションＩＤ保持用
var FALSE = false;          // TRUE定数の宣言 //
var TRUE = true;            // TRUE定数の宣言 //
var winlist = [];           // 子window管理用配列

window.onunload=CloseWinsDLG;

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
 var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
   var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
   if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_preloadImages() { //v3.0
    var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
        var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
        if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_nbGroup(event, grpName){ //v3.0
	var i,img,nbArr,args=MM_nbGroup.arguments;
	if (event == "init" && args.length > 2){
		if ((img = MM_findObj(args[2])) != null && !img.MM_init){
			img.MM_init = true; img.MM_up = args[3]; img.MM_dn = img.src;
			if ((nbArr = document[grpName]) == null) nbArr = document[grpName] = new Array();
			nbArr[nbArr.length] = img;
			for (i=4; i < args.length-1; i+=2) {
				if ((img = MM_findObj(args[i])) != null){
					if (!img.MM_up) img.MM_up = img.src;
					img.src = img.MM_dn = args[i+1];
					nbArr[nbArr.length] = img;
				}
			}
		}
	} else if (event == "over"){
			document.MM_nbOver = nbArr = new Array();
			for (i=1; i < args.length-1; i+=3){
				if ((img = MM_findObj(args[i])) != null){
					if (!img.MM_up) img.MM_up = img.src;
					img.src = (img.MM_dn && args[i+2]) ? args[i+2] : args[i+1];
					nbArr[nbArr.length] = img;
				}
			}
	} else if (event == "out" ){
		for (i=0; i < document.MM_nbOver.length; i++){
			img = document.MM_nbOver[i]; img.src = (img.MM_dn) ? img.MM_dn : img.MM_up;
		}
	} else if (event == "down"){
		if ((nbArr = document[grpName]) != null){
			for (i=0; i < nbArr.length; i++) { img=nbArr[i]; img.src = img.MM_up; img.MM_dn = 0; }
			document[grpName] = nbArr = new Array();
			for (i=2; i < args.length-1; i+=2) if ((img = MM_findObj(args[i])) != null){
				if (!img.MM_up) img.MM_up = img.src;
				img.src = img.MM_dn = args[i+1];
				nbArr[nbArr.length] = img;
			}
		}
	}
}

/*------------------------------------------------*/
//フルスクリーンウィンドウ立上後、データ送信
//
//url            : データ送信先URL
//targetname     : データ送信を行なうウィンドウハンドル名
//type           : ロジックの動作方法 (なし or 0 or 1)
//name           : セレクトボックスの名前
/*------------------------------------------------*/
function OpenWins(url, targetname, type, name) {

	if (type){
		// 入力フォーム内のデータをフルスクリーンウィンドウにサブミット
		////winlist[targetname] = window.open('dummy.html', targetname, "Fullscreen=yes,type=Fullwindow,scrollbars=yes");
		//winlist.push(window.open('nowloading.jsp', targetname, "width=1000,height=700,top=0,left=0,resizable=yes,scrollbars=yes,location=no,menubar=no,toolbar=no,status=no"));
		//winlist[winlist.length - 1].resizeTo(screen.availWidth+3,screen.availHeight);
		winlist.push(window.open('nowloading.jsp', targetname, "Fullscreen=yes,type=Fullwindow,top=0,left=0,resizable=yes,scrollbars=yes,location=no,menubar=no,toolbar=no,status=no"));
		// 入力フォーム内の該当するリストボックスデータを全選択し、フルスクリーンウィンドウにサブミット
		if (name){
			var s = document.forms[0].elements[name].options;
			for( i = 0 ; i < s.length - 1 ; i ++ ){
				s[i].selected = true;
			}
		}
		document.forms[0].action = url;
		document.forms[0].target = targetname;
		document.forms[0].submit();
	}else{
		// フルスクリーンを普通に立上げる
		////winlist[targetname] = window.open(url, targetname, "Fullscreen=yes,type=Fullwindow,scrollbars=yes");
		winlist.push(window.open(url, targetname, "Fullscreen=yes,type=Fullwindow,top=0,left=0,resizable=yes,scrollbars=yes,location=no,menubar=no,toolbar=no,status=no"));
		winlist[winlist.length - 1].resizeTo(screen.availWidth+3,screen.availHeight);
	}
}

/*------------------------------------------------*/
// ログアウト処理
/*------------------------------------------------*/
function PreLogout(sid){

	opener.document.forms[0].logot.value = 1;
	opener.OpenChildren(window.name, '', sid);
	window.close();

}

/*------------------------------------------------*/
// ダイアログ表示
/*------------------------------------------------*/
function OpenChildrenDLG(obj, url, sid, wid, hei) {

	if (!wid) wid = 580;
	if (!hei) hei = 517;

	winlist.push(window.open(url, "winhndl00" , "width=" + wid + ",height=" + hei + ",top=100,left=210,resizable=no,scrollbars=no,location=no,menubar=no,toolbar=no,status=no"));
	winlist[winlist.length - 1].focus();
}

/*------------------------------------------------*/
// ダイアログ表示２
/*------------------------------------------------*/
function OpenChildrenDLG2(obj, url, sid, wid, hei) {

	if (!wid) wid = 580;
	if (!hei) hei = 517;

	winlist.push(window.open(url, "winhndl02" , "width=" + wid + ",height=" + hei + ",top=100,left=210,resizable=no,scrollbars=no,location=no,menubar=no,toolbar=no,status=no"));
	winlist[winlist.length - 1].focus();

}

/*------------------------------------------------*/
// ダイアログ表示
/*------------------------------------------------*/
function OpenChildrenDsDLG(obj, url, targetname, wid, hei, direct) {
	var top = 0;
	var left = (screen.width - wid) / 2;

	if (!wid) wid = 580;
	if (!hei) hei = 517;
	if (!targetname) targetname = "winhndl03";
	if (!direct) direct = "up";

	if (direct == "down") {
		top = screen.height - hei - 80;
	}
	
	// 入力フォーム内のデータをフルスクリーンウィンドウにサブミット
	winlist.push(window.open('nowloading.jsp?hspace=20', targetname, "width=" + wid + ",height=" + hei +",top=" + top + ",left=" + left + ",resizable=no,scrollbars=no,location=no,menubar=no,toolbar=no,status=no"));
	winlist[winlist.length - 1].focus();

	document.forms[0].action = url;
	document.forms[0].target = targetname;
	document.forms[0].submit();
}

/*------------------------------------------------*/
// ダイアログ閉じる
/*------------------------------------------------*/
function CloseWinsDLG() {

	if (winlist.length > 0){
		for (var i = 0;i<= winlist.length - 1;i++) {
			if (winlist[i]){
				try {
					winlist[i].close();
					winlist[i] = null;
				} catch(e) {
				}
			}
		}
	}
}

/*------------------------------------------------*/
//フルスクリーンウィンドウ立上後、データ送信
//
//url            : データ送信先URL
//targetname     : データ送信を行なうウィンドウハンドル名
//type           : ロジックの動作方法 (なし or 0 or 1)
//name           : セレクトボックスの名前
/*------------------------------------------------*/
function OpenWinsCommit(url, targetname) {

	// 入力フォーム内のデータをフルスクリーンウィンドウにサブミット
	////winlist[targetname] = window.open('dummy.html', targetname, "Fullscreen=yes,type=Fullwindow,scrollbars=yes");
	winlist.push(window.open('nowloading.jsp', targetname, "width=320,height=240,top=0,left=0,resizable=no,scrollbars=yes,location=no,menubar=no,toolbar=no,status=no"));
	document.forms[0].action = url;
	document.forms[0].target = targetname;
	document.forms[0].submit();
}

/*------------------------------------------------*/
//フルスクリーンウィンドウ立上後、データ送信
//
//url            : データ送信先URL
//targetname     : データ送信を行なうウィンドウハンドル名
//type           : ロジックの動作方法 (なし or 0 or 1)
//name           : セレクトボックスの名前
/*------------------------------------------------*/
function WinsCommit(url, targetname) {

	document.forms[0].action = url;
	document.forms[0].target = targetname;
	document.forms[0].submit();
}

/*------------------------------------------------*/
// ＰＤＦ用ウィンドウ表示
/*------------------------------------------------*/
function OpenPDFWins(url) {

	if (document.form1){
		if (document.form1.elements["select"]){
			url = url + "&select=" + document.form1.elements["select"].value;
		}
	}

	url=url.replace(/=/g,"_");
	var winTitle=url.replace(/\//g,"");
	winTitle=winTitle.replace(/=/g,"");
	winTitle=winTitle.replace(/_/g,"");
	winTitle=winTitle.replace(/\./g,"");
	winTitle=winTitle.replace(/\;/g,"");
	winTitle=winTitle.replace(/\?/g,"");
	winTitle=winTitle.replace(/\&/g,"");
	winlist.push(window.open(url, winTitle , "width=1000,height=700,top=10,left=10,resizable=no,scrollbars=no,location=no,menubar=no,toolbar=no,status=no,dependent=yes"));

}


/*------------------------------------------------*/
// ＰＤＦ用ウィンドウ表示
/*------------------------------------------------*/
function OpenPDFWinsForward(url) {

	if (document.form1){
		if (document.form1.elements["select"]){
			url = url + "&select=" + document.form1.elements["select"].value;
		}
	}
	
	var winTitle=url.replace(/\//g,"");
	winTitle=winTitle.replace(/=/g,"");
	winTitle=winTitle.replace(/_/g,"");
	winTitle=winTitle.replace(/\./g,"");
	winTitle=winTitle.replace(/\;/g,"");
	winTitle=winTitle.replace(/\?/g,"");
	winTitle=winTitle.replace(/\&/g,"");
	winlist.push(window.open(url, winTitle , "width=1000,height=700,top=10,left=10,resizable=no,scrollbars=no,location=no,menubar=no,toolbar=no,status=no,dependent=yes"));

}

/*------------------------------------------------*/
// 拡大画像用ウィンドウ表示
/*------------------------------------------------*/
function OpenIMGWins(url, wid, hei, name, resize, scrlbar) {

	if (!name) name = '0';
	if (!wid) wid = 640;
	if (!hei) hei = 530;
	//if (!resize) resize = 'yes';
	resize = 'yes';
	//if (!scrlbar) scrlbar = 'no';
	scrlbar = 'yes';
	btnname = name;

	wid += 20;
	hei += 20;

	winlist.push(window.open(url, name , "width=" + wid + ",height=" + hei + ",top=0,left=0,resizable=" + resize + ",scrollbars=" + scrlbar + ",location=no,menubar=no,toolbar=no,status=no"));
	winlist[winlist.length - 1].resizeTo(wid+20,hei+20);
	winlist[winlist.length - 1].focus();

}

/*------------------------------------------------*/
// 拡大画像用ウィンドウ表示
/*------------------------------------------------*/
function OpenMGNFYIMGWins(url, wid, hei, name) {

	if (!name) name = '0';
	if (!wid) wid = 660;
	if (!hei) hei = 530;
	btnname = name;

	wid += 20;
	hei += 20;

	winlist.push(window.open(url, name , "width=" + wid + ",height=" + hei + ",top=0,left=0,resizable=yes,scrollbars=no,location=no,menubar=no,toolbar=no,status=no"));
	winlist[winlist.length - 1].resizeTo(wid+20,hei+20);
	winlist[winlist.length - 1].focus();

}

/*------------------------------------------------*/
// 子window open管理（絞り込み専用）
/*------------------------------------------------*/
function OpenSbrkm(obj, url, winname, sid) {
	winlist.push(window.open(url, winname, "width=597,height=600,top=100,left=210,resizable=no,scrollbars=yes,location=no,menubar=no,toolbar=no,status=no"));
	winlist[winlist.length - 1].focus();
}

/*------------------------------------------------*/
// 子window open管理（絞り込みプルダウン専用）
/*------------------------------------------------*/
function OpenSbrkmSBMT(obj, url, winname, name) {
	if (name){
		if (document.forms[0].elements[name].value) {
			winlist.push(window.open('', winname, "width=597,height=600,top=100,left=210,resizable=no,scrollbars=yes,location=no,menubar=no,toolbar=no,status=no"));
			SelectTargetSub(url, winname);
			winlist[winlist.length - 1].focus();
		}
	}
}

/*------------------------------------------------*/
// 子window close管理（絞り込み専用）
/*------------------------------------------------*/
function CloseSbrkm() {
	CloseWinsDLG();
}

/*------------------------------------------------*/
// ＰＯＳＴ送信
/*------------------------------------------------*/
function SelectTargetSub(target, tar){

	document.forms[0].action = target;
	if (tar != null)
		document.forms[0].target = tar;
	document.forms[0].submit();
}

/*------------------------------------------------*/
// ＰＯＳＴ送信
/*------------------------------------------------*/
function intgSelectTargetSub(target, tar){
	parent.rightChildFrame.document.forms[0].action = target;
	if (tar != null) {
		parent.rightChildFrame.document.forms[0].target = tar;
	}
	parent.rightChildFrame.document.forms[0].submit();
}

/*------------------------------------------------*/
// ＰＯＳＴ送信(並べ替えプルダウン専用)
/*------------------------------------------------*/
function SortSelectTargetSub(target, tar, name) {
	if (name){
		if (document.forms[0].elements[name].value) {
			SelectTargetSub(target, tar);
		}
	}
}

/*------------------------------------------------*/
// チェックボタンの一括チェック
/*------------------------------------------------*/
function PreAllCheck(obj,obj_name,bool){

	for(i=0; i<obj.length; i++){
		if (obj[i].name.substring(0,3) == obj_name) {
			obj[i].checked = bool;
		}
	}
}

/*------------------------------------------------*/
// 個別開催会場のチェック
/*------------------------------------------------*/
function PreIntgcb0Check(obj,bool){

	var tagNames = parent.leftChildFrame.document.getElementsByTagName("input");

	var str = "";
	for (i in tagNames) {

		if (tagNames[i].name != undefined) {
			str = tagNames[i].name;
			if ((str == "cb0[A1]") || (str == "cb0[A2]") || (str == "cb0[A3]") || (str == "cb0[A4]") || (str == "cb0[A5]") || 
				(str == "cb0[A6]") || (str == "cb0[A7]") || (str == "cb0[A8]") || (str == "cb0[A9]") || 
				(str == "cb0[A10]") || (str == "cb0[A11]")){
				tagNames[i].checked = bool;
				parent.rightChildFrame.document.getElementById(str).checked = bool;
			}
		}
	}
}

/*------------------------------------------------*/
// 個別開催会場のチェック
/*------------------------------------------------*/
function PreIntgcb0CheckBidAA(obj,bool){
	var str = "";
	for(i=0; i<obj.length; i++){
		str = obj[i].name;
		if ((str == "cb0[A1]") || (str == "cb0[A2]") || (str == "cb0[A3]") || (str == "cb0[A4]") || (str == "cb0[A5]") || 
			(str == "cb0[A6]") || (str == "cb0[A7]") || (str == "cb0[A8]") || (str == "cb0[A9]") || 
			(str == "cb0[A10]") || (str == "cb0[A11]")){
			if (bool) {
				if (str == "cb0[A5]") {
					obj[i].checked = true;
				} else {
					obj[i].checked = false;
				}
			} else {
				if (str == "cb0[A5]") {
					obj[i].checked = false;
				} else {
					/* obj[i].checked = true; 入札市場廃止対応 */
				}
			}
		}
	}
}

/*------------------------------------------------*/
// チェックボタンの一括チェック
/*------------------------------------------------*/
function PreIntgcb1Check(obj,obj_name,bool){

	var tagNames = parent.rightChildFrame.document.getElementsByTagName("input");

	for (i in tagNames) {

		if (tagNames[i].name != undefined) {
			if (tagNames[i].name.substring(0,3) == obj_name) {
				tagNames[i].checked = bool;
			}
		}
	}
}

/*------------------------------------------------*/
// チェックボタンのチェック（国産車）
/*------------------------------------------------*/
function PreKokusanCheck(obj, bool){

	for(i=0; i<obj.length; i++){
		if (obj[i].name.match(/^cb2\[([0-9]+)\]/)) {
			n = Number( RegExp.$1 );
			if (n >= 0 && n < 10){
				obj[i].checked = bool;
			}
		}
	}
}

/*------------------------------------------------*/
// チェックボタンのチェック（輸入車）
/*------------------------------------------------*/
function PreYunyuCheck(obj, bool){

	for(i=0; i<obj.length; i++){
		if (obj[i].name.match(/^cb2\[([0-9]+)\]/)) {
			n = Number( RegExp.$1 );
			if (n >= 10 && n < 26){
				obj[i].checked = bool;
			}
		}
	}
}

/*------------------------------------------------*/
// 開催会場のチェック
/*------------------------------------------------*/
function PreHlCheck(obj, offset, strt){

	var bool;
	var cnt = 0;
	var ttl = 0;

	// 事前にチェック状況を調べる
	for(i=0; i<obj.length; i++){
		if (obj[i].name.match(/^cb1\[([0-9]+)\]/)) {
			n = Number( RegExp.$1 );
			if ((n % 7) == offset){
				if (obj[i]){
					ttl++;
					if (obj[i].checked == true){
						cnt++;
					}
				}
			}
		}
	}

	if (cnt == 0){
		// なにも選択されていない時はボタンクリック時はチェック
		bool = true;
	}else{
		if (ttl == cnt){
			// すべて選択されている時はボタンクリック時はチェックオフ
			bool = false;
		}else{
			// 中途半端は全部ＯＮ
			bool = true;
		}
	}

	for(i=0; i<obj.length; i++){
		if (obj[i].name.match(/^cb1\[([0-9]+)\]/)) {
			n = Number( RegExp.$1 );
			if ((n % 7) == offset){
				if (obj[i]){
					obj[i].checked = bool;
				}
			}
		}
	}
}

/*------------------------------------------------*/
// 個別開催会場のチェック
/*------------------------------------------------*/
function Precb0Check(obj){
	var cnt = 0;
	var max = 10;
	var str = "";
	for(i=0; i<obj.length; i++){
		str = obj[i].name;
		if ((str == "cb0[A1]") || (str == "cb0[A2]") || (str == "cb0[A3]") || (str == "cb0[A4]") || 
			(str == "cb0[A6]") || (str == "cb0[A7]") || (str == "cb0[A8]") || (str == "cb0[A9]") || 
			(str == "cb0[A10]") || (str == "cb0[A11]")){
			if (obj[i].checked == true){
				cnt++;
			}
		}
	}
	var bool = true;
	if (cnt == max){
		bool = false;
	}
	document.getElementById("cb0[A1]").checked = bool;
	document.getElementById("cb0[A2]").checked = bool;
	document.getElementById("cb0[A3]").checked = bool;
	document.getElementById("cb0[A4]").checked = bool;
	document.getElementById("cb0[A6]").checked = bool;
	document.getElementById("cb0[A7]").checked = bool;
	document.getElementById("cb0[A8]").checked = bool;
	document.getElementById("cb0[A9]").checked = bool;
	document.getElementById("cb0[A10]").checked = bool;
	document.getElementById("cb0[A11]").checked = bool;
	parent.rightChildFrame.document.getElementById("cb0[A1]").checked = bool;
	parent.rightChildFrame.document.getElementById("cb0[A2]").checked = bool;
	parent.rightChildFrame.document.getElementById("cb0[A3]").checked = bool;
	parent.rightChildFrame.document.getElementById("cb0[A4]").checked = bool;
	parent.rightChildFrame.document.getElementById("cb0[A6]").checked = bool;
	parent.rightChildFrame.document.getElementById("cb0[A7]").checked = bool;
	parent.rightChildFrame.document.getElementById("cb0[A8]").checked = bool;
	parent.rightChildFrame.document.getElementById("cb0[A9]").checked = bool;
	parent.rightChildFrame.document.getElementById("cb0[A10]").checked = bool;
	parent.rightChildFrame.document.getElementById("cb0[A11]").checked = bool;
}

/*------------------------------------------------*/
// 個別開催会場のチェック
/*------------------------------------------------*/
function Precb1Check(obj, str){
	for(i=0; i<obj.length; i++){
		if (obj[i].name == str){
			if (obj[i].checked == true){
				obj[i].checked = false;
			}else{
				obj[i].checked = true;
			}
			if ((parent.rightChildFrame != null) && (parent.rightChildFrame != undefined)){
				parent.rightChildFrame.document.getElementById(str).checked = obj[i].checked;
			}
			return;
		}
	}
}

/*------------------------------------------------*/
// 個別開催会場のチェック
/*------------------------------------------------*/
function Precb2Check(obj, str){
	for(i=0; i<obj.length; i++){
		if (obj[i].name == str){
			if (obj[i].checked == true){
				obj[i].checked = false;
			}else{
				obj[i].checked = true;
			}
			return;
		}
	}
}

/*------------------------------------------------*/
// 個別開催会場のチェック
/*------------------------------------------------*/
function Precb0AllCheck(obj,bool){

	document.getElementById("cb0[A1]").checked = bool;
	document.getElementById("cb0[A2]").checked = bool;
	document.getElementById("cb0[A3]").checked = bool;
	document.getElementById("cb0[A4]").checked = bool;
	document.getElementById("cb0[A6]").checked = bool;
	document.getElementById("cb0[A7]").checked = bool;
	document.getElementById("cb0[A8]").checked = bool;
	document.getElementById("cb0[A9]").checked = bool;
	document.getElementById("cb0[A10]").checked = bool;
	document.getElementById("cb0[A11]").checked = bool;
}

/*------------------------------------------------*/
// 個別開催会場のチェック
/*------------------------------------------------*/
function LightPrecb1Check(obj, str){
	
	var boolA9 = false;
	var boolA10 = false;
	for(i=0; i<obj.length; i++){
		if (obj[i].name == str){
			obj[i].checked = true;
		} else {
			obj[i].checked = false;
		}
		if (obj[i].name == "cb0[A4]"){
			boolA9 = obj[i].checked;
		}
		if (obj[i].name == "cb0[A2]"){
			boolA10 = obj[i].checked;
		}
	}
	document.getElementById("cb0[A9]").checked = boolA9;
	document.getElementById("cb0[A10]").checked = boolA10;
	document.getElementById("cb0[A11]").checked = boolA10;
}

/*------------------------------------------------*/
// 入札可のみチェックボタンの一括チェック
/*------------------------------------------------*/
function PreEnblBidCheck(obj, obj_name){

	var tagNames = document.getElementsByTagName("input");
	
	for (i in tagNames) {

		if (tagNames[i].name != undefined) {
			if (tagNames[i].name.substring(0,3) == obj_name) {
				if (tagNames[i].getAttribute("targetEnableBid")=="1") {
					tagNames[i].checked = true;
				} else {
					tagNames[i].checked = false;
				}
			}
		}
	}
}

/*------------------------------------------------*/
// マイリスト登録制御
//
// kore :objectの名称
// param:マイリスト登録・削除pgmに渡す引数
// rld  :リロード要否
// param:リスト区分（リロード時のみ使用）
/*------------------------------------------------*/
function MListIns(kore, param, rld, lstkbn, subsys) {
	// チェックＢＯＸのメソッドを変数に割り当て
	elm = document.form1.elements[kore];

	// セッションＩＤを取得する
	sid = "PHPSESSID=" + document.form1.elements["PHPSESSID"].value;
	val = "premylst01.jsp?" + sid + "&param=" + param + (elm.checked ? "1":"0");
	if (subsys == "TRI_"){
		opener.opener.top.B.location.href = val;
	}else{
		opener.top.B.location.href = val;
	}

	// 画面のリロード要否
	if (rld){
		document.form1.action = "premylst02.jsp?" + sid + "&lstkbn=" + lstkbn;
		document.form1.target = "_self";
		window.setTimeout("document.form1.submit()", 50);
	}
}

/*------------------------------------------------*/
// マイリスト登録制御　会場詳細画面用
//
// param:マイリスト登録に渡す引数
/*------------------------------------------------*/
function MListInsDtl(param) {

	// セッションＩＤを取得する
	sid = document.form1.elements["sessid"].value;
	val = "premylst01.jsp?" + sid + "&param=" + param + "1";
	opener.top.B.location.href = val;
}

/*------------------------------------------------*/
// 相場マイリスト登録制御
//
// kore :objectの名称
// param:マイリスト登録・削除pgmに渡す引数
// rld  :リロード要否
// param:リスト区分（リロード時のみ使用）
/*------------------------------------------------*/
function MListInfIns(kore, param, rld, lstkbn, subsys) {
	// チェックＢＯＸのメソッドを変数に割り当て
	elm = document.form1.elements[kore];

	// セッションＩＤを取得する
	sid = "PHPSESSID=" + document.form1.elements["PHPSESSID"].value;
	val = "premyinf01.jsp?" + sid + "&param=" + param + (elm.checked ? "1":"0");
	//window.alert(subsys);
	if ((subsys != "INF") && (subsys != "IML")){
		opener.opener.top.B.location.href = val;
	}else{
		opener.top.B.location.href = val;
	}

	// 画面のリロード要否
	if (rld){
		document.form1.action = "premyinf02.jsp?" + sid + "&lstkbn=" + lstkbn;
		document.form1.target = "_self";
		window.setTimeout("document.form1.submit()", 50);
	}
}

/*------------------------------------------------*/
// 相場マイリスト登録制御　会場詳細画面用
//
// param:マイリスト登録に渡す引数
/*------------------------------------------------*/
function MListInfInsDtl(param) {

	// セッションＩＤを取得する
	sid = document.form1.elements["sessid"].value;
	val = "premyinf01.jsp?" + sid + "&param=" + param + "1";
	opener.top.B.location.href = val;
}

/*------------------------------------------------*/
// 戻る
/*------------------------------------------------*/
function Historyback(){

	history.back();
}

/*------------------------------------------------*/
// 出品NO入力エリアのクリア
/*------------------------------------------------*/
function EntTxtClear() {

	document.form1.elements["txt1[1]"].value = "";
	document.form1.elements["txt1[2]"].value = "";
	document.form1.elements["txt2[1]"].value = "";
	document.form1.elements["txt2[2]"].value = "";
	document.form1.elements["txt2[3]"].value = "";
	document.form1.elements["txt2[4]"].value = "";
	document.form1.elements["txt2[5]"].value = "";
	document.form1.elements["txt2[6]"].value = "";
}

/*------------------------------------------------*/
// リクエストサービス制御
//
// kore  : objectの名称
// param : リクエスト制御プログラムに渡す引数
// rld   : リロード要否
/*------------------------------------------------*/
function RqProcCtl(kore, param, rld) {

	// チェックＢＯＸのメソッドを変数に割り当て
	elm = document.form1.elements[kore];

	// セッションＩＤを取得する
	sid = document.form1.elements["sessid"].value;
	val = "prerqcnd02.jsp?" + sid + "&param=" + param;
	opener.top.B.location.href = val;

	// 画面のリロード要否
	if (rld){
		document.form1.action = "prerqcnd01.jsp?" + sid + '&fnc=back';
		document.form1.target = "_self";
		window.setTimeout("document.form1.submit()", 50);
	}

}

/*------------------------------------------------*/
// セレクトボックス内の項目追加
//
// obj    : objectの名称
// list   : セレクトボックス1 選択する側
// select : セレクトボックス2 選択した項目
/*------------------------------------------------*/
function AddSelect( obj, list, select ){
	var l = obj[list].options;
	var s = obj[select].options;
	for( i = 0 ; i < l.length - 1 ; i ++ ){

		//list_valu = l[i].value;
		//window.alert(list_valu);

		var co = l[i];
		if( ! co.selected || ! co.value ){
			continue;
		}
		var f = false;
		var li = s.length - 1;
		for( j = 0 ; j < li ; j ++ ){
			if( s[j].value == co.value ){
				f = true; break;
			}
		}
		if( f ){
			continue;
		}
		s[s.length] = new Option( s[li].text, "" );
		s[li] = new Option( co.text, co.value, true, true );
	}
}

/*------------------------------------------------*/
// セレクトボックス内の項目削除
//
// obj    : objectの名称
// select : セレクトボックス2 選択した項目
/*------------------------------------------------*/
function RemoveSelect( obj, select ){
	var s = obj[select].options;
	for( i = 0; i < s.length - 1; i ++ ){
		if( s[i].selected ){
			s[i] = null;
			i -= 1;
		}
	}
}

//------------------------------------------------
// JavaScriptによるリンク関数
//
// url    : リンク先ページ
//------------------------------------------------
function JSPageLocation( url, flg ){
	if (flg) {
		// プロトコル設定
		var prtclstr = window.location.protocol;
		re = new RegExp('https', 'i');
		if (prtclstr.match(re)) {
			prtclstr = 'https://';
		} else {
			prtclstr = 'http://';
		}
		// ホスト名設定
		var hostname = window.location.host;
		// パス名設定
		var pathname = window.location.pathname;
		var searchlength = pathname.lastIndexOf('/');
		if (0 >= searchlength) {
			searchlength = length(pathname);
		}
		pathname = pathname.substr(0, (searchlength + 1));

		// ページリンクをする
		window.location.href = prtclstr+hostname+pathname+url;
	} else {
	document.forms[0].action = url;
	document.forms[0].target = '_self';
	document.forms[0].submit();
	}
}

/*------------------------------------------------*/
// マイリスト登録制御
//
// chkbox:objectの名称
// href: マイリスト登録・削除URL
/*------------------------------------------------*/
function MListIns2(chkbox, href){
	elm = document.form1.elements[chkbox];
	val = href + "&action=" + (elm.checked ? "insert" : "delete");
	document.location.href = val;
}

/*------------------------------------------------*/
// リクエストサービス制御
//
// chkbox:objectの名称
// href: 削除・延長URL
/*------------------------------------------------*/
function RqProcCtl2(href){
	document.location.href = href;
}

/*------------------------------------------------*/
// オープンウインドウ制御
//
// url: データ送信先URL
// name: ウィンドウ名
/*------------------------------------------------*/
function sousaWin(url,name) {

	if (!name)
		name = '0';

	winlist.push(window.open(url,name,"width=800,height=480,top=0,left=0,resizable=yes,scrollbars=yes,location=no,menubar=no,toolbar=no,status=no"));
	winlist[winlist.length - 1].focus();
}

function btnNextchangeImage(parm) {

	//var s = "";
	//for (i in document.getElementById("btnNext").src) {
		//s += i + "=" + document.getElementById("btnNext") + "<br>";
	//}
	//document.getElementById("test").innerHTML = s;

	document.getElementById("btnNext").src = parm;

}


// StringクラスにTrimメソッドの追加
String.prototype.trim = function() {
    return this.replace(/^[ ]+|[ ]+$/g, '');
}
