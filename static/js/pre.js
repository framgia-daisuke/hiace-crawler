/******************************************************************************
 * pre.js
 *
 * Program      Javascript�֐����C�u����
 * Date         2003-02-07
 *
 * @package     prebit/admin
 * @access      public
 * @author      kenji kimura
 * @version     $Id: pre.js,v 1.16 2012/01/20 06:03:49 iauc Exp $
 *
 */
/******************************************************************************/

var SID;                    // �Z�b�V�����h�c�ێ��p
var FALSE = false;          // TRUE�萔�̐錾 //
var TRUE = true;            // TRUE�萔�̐錾 //
var winlist = [];           // �qwindow�Ǘ��p�z��

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
//�t���X�N���[���E�B���h�E�����A�f�[�^���M
//
//url            : �f�[�^���M��URL
//targetname     : �f�[�^���M���s�Ȃ��E�B���h�E�n���h����
//type           : ���W�b�N�̓�����@ (�Ȃ� or 0 or 1)
//name           : �Z���N�g�{�b�N�X�̖��O
/*------------------------------------------------*/
function OpenWins(url, targetname, type, name) {

	if (type){
		// ���̓t�H�[�����̃f�[�^���t���X�N���[���E�B���h�E�ɃT�u�~�b�g
		////winlist[targetname] = window.open('dummy.html', targetname, "Fullscreen=yes,type=Fullwindow,scrollbars=yes");
		//winlist.push(window.open('nowloading.jsp', targetname, "width=1000,height=700,top=0,left=0,resizable=yes,scrollbars=yes,location=no,menubar=no,toolbar=no,status=no"));
		//winlist[winlist.length - 1].resizeTo(screen.availWidth+3,screen.availHeight);
		winlist.push(window.open('nowloading.jsp', targetname, "Fullscreen=yes,type=Fullwindow,top=0,left=0,resizable=yes,scrollbars=yes,location=no,menubar=no,toolbar=no,status=no"));
		// ���̓t�H�[�����̊Y�����郊�X�g�{�b�N�X�f�[�^��S�I�����A�t���X�N���[���E�B���h�E�ɃT�u�~�b�g
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
		// �t���X�N���[���𕁒ʂɗ��グ��
		////winlist[targetname] = window.open(url, targetname, "Fullscreen=yes,type=Fullwindow,scrollbars=yes");
		winlist.push(window.open(url, targetname, "Fullscreen=yes,type=Fullwindow,top=0,left=0,resizable=yes,scrollbars=yes,location=no,menubar=no,toolbar=no,status=no"));
		winlist[winlist.length - 1].resizeTo(screen.availWidth+3,screen.availHeight);
	}
}

/*------------------------------------------------*/
// ���O�A�E�g����
/*------------------------------------------------*/
function PreLogout(sid){

	opener.document.forms[0].logot.value = 1;
	opener.OpenChildren(window.name, '', sid);
	window.close();

}

/*------------------------------------------------*/
// �_�C�A���O�\��
/*------------------------------------------------*/
function OpenChildrenDLG(obj, url, sid, wid, hei) {

	if (!wid) wid = 580;
	if (!hei) hei = 517;

	winlist.push(window.open(url, "winhndl00" , "width=" + wid + ",height=" + hei + ",top=100,left=210,resizable=no,scrollbars=no,location=no,menubar=no,toolbar=no,status=no"));
	winlist[winlist.length - 1].focus();
}

/*------------------------------------------------*/
// �_�C�A���O�\���Q
/*------------------------------------------------*/
function OpenChildrenDLG2(obj, url, sid, wid, hei) {

	if (!wid) wid = 580;
	if (!hei) hei = 517;

	winlist.push(window.open(url, "winhndl02" , "width=" + wid + ",height=" + hei + ",top=100,left=210,resizable=no,scrollbars=no,location=no,menubar=no,toolbar=no,status=no"));
	winlist[winlist.length - 1].focus();

}

/*------------------------------------------------*/
// �_�C�A���O�\��
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
	
	// ���̓t�H�[�����̃f�[�^���t���X�N���[���E�B���h�E�ɃT�u�~�b�g
	winlist.push(window.open('nowloading.jsp?hspace=20', targetname, "width=" + wid + ",height=" + hei +",top=" + top + ",left=" + left + ",resizable=no,scrollbars=no,location=no,menubar=no,toolbar=no,status=no"));
	winlist[winlist.length - 1].focus();

	document.forms[0].action = url;
	document.forms[0].target = targetname;
	document.forms[0].submit();
}

/*------------------------------------------------*/
// �_�C�A���O����
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
//�t���X�N���[���E�B���h�E�����A�f�[�^���M
//
//url            : �f�[�^���M��URL
//targetname     : �f�[�^���M���s�Ȃ��E�B���h�E�n���h����
//type           : ���W�b�N�̓�����@ (�Ȃ� or 0 or 1)
//name           : �Z���N�g�{�b�N�X�̖��O
/*------------------------------------------------*/
function OpenWinsCommit(url, targetname) {

	// ���̓t�H�[�����̃f�[�^���t���X�N���[���E�B���h�E�ɃT�u�~�b�g
	////winlist[targetname] = window.open('dummy.html', targetname, "Fullscreen=yes,type=Fullwindow,scrollbars=yes");
	winlist.push(window.open('nowloading.jsp', targetname, "width=320,height=240,top=0,left=0,resizable=no,scrollbars=yes,location=no,menubar=no,toolbar=no,status=no"));
	document.forms[0].action = url;
	document.forms[0].target = targetname;
	document.forms[0].submit();
}

/*------------------------------------------------*/
//�t���X�N���[���E�B���h�E�����A�f�[�^���M
//
//url            : �f�[�^���M��URL
//targetname     : �f�[�^���M���s�Ȃ��E�B���h�E�n���h����
//type           : ���W�b�N�̓�����@ (�Ȃ� or 0 or 1)
//name           : �Z���N�g�{�b�N�X�̖��O
/*------------------------------------------------*/
function WinsCommit(url, targetname) {

	document.forms[0].action = url;
	document.forms[0].target = targetname;
	document.forms[0].submit();
}

/*------------------------------------------------*/
// �o�c�e�p�E�B���h�E�\��
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
// �o�c�e�p�E�B���h�E�\��
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
// �g��摜�p�E�B���h�E�\��
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
// �g��摜�p�E�B���h�E�\��
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
// �qwindow open�Ǘ��i�i�荞�ݐ�p�j
/*------------------------------------------------*/
function OpenSbrkm(obj, url, winname, sid) {
	winlist.push(window.open(url, winname, "width=597,height=600,top=100,left=210,resizable=no,scrollbars=yes,location=no,menubar=no,toolbar=no,status=no"));
	winlist[winlist.length - 1].focus();
}

/*------------------------------------------------*/
// �qwindow open�Ǘ��i�i�荞�݃v���_�E����p�j
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
// �qwindow close�Ǘ��i�i�荞�ݐ�p�j
/*------------------------------------------------*/
function CloseSbrkm() {
	CloseWinsDLG();
}

/*------------------------------------------------*/
// �o�n�r�s���M
/*------------------------------------------------*/
function SelectTargetSub(target, tar){

	document.forms[0].action = target;
	if (tar != null)
		document.forms[0].target = tar;
	document.forms[0].submit();
}

/*------------------------------------------------*/
// �o�n�r�s���M
/*------------------------------------------------*/
function intgSelectTargetSub(target, tar){
	parent.rightChildFrame.document.forms[0].action = target;
	if (tar != null) {
		parent.rightChildFrame.document.forms[0].target = tar;
	}
	parent.rightChildFrame.document.forms[0].submit();
}

/*------------------------------------------------*/
// �o�n�r�s���M(���בւ��v���_�E����p)
/*------------------------------------------------*/
function SortSelectTargetSub(target, tar, name) {
	if (name){
		if (document.forms[0].elements[name].value) {
			SelectTargetSub(target, tar);
		}
	}
}

/*------------------------------------------------*/
// �`�F�b�N�{�^���̈ꊇ�`�F�b�N
/*------------------------------------------------*/
function PreAllCheck(obj,obj_name,bool){

	for(i=0; i<obj.length; i++){
		if (obj[i].name.substring(0,3) == obj_name) {
			obj[i].checked = bool;
		}
	}
}

/*------------------------------------------------*/
// �ʊJ�É��̃`�F�b�N
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
// �ʊJ�É��̃`�F�b�N
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
					/* obj[i].checked = true; ���D�s��p�~�Ή� */
				}
			}
		}
	}
}

/*------------------------------------------------*/
// �`�F�b�N�{�^���̈ꊇ�`�F�b�N
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
// �`�F�b�N�{�^���̃`�F�b�N�i���Y�ԁj
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
// �`�F�b�N�{�^���̃`�F�b�N�i�A���ԁj
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
// �J�É��̃`�F�b�N
/*------------------------------------------------*/
function PreHlCheck(obj, offset, strt){

	var bool;
	var cnt = 0;
	var ttl = 0;

	// ���O�Ƀ`�F�b�N�󋵂𒲂ׂ�
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
		// �Ȃɂ��I������Ă��Ȃ����̓{�^���N���b�N���̓`�F�b�N
		bool = true;
	}else{
		if (ttl == cnt){
			// ���ׂđI������Ă��鎞�̓{�^���N���b�N���̓`�F�b�N�I�t
			bool = false;
		}else{
			// ���r���[�͑S���n�m
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
// �ʊJ�É��̃`�F�b�N
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
// �ʊJ�É��̃`�F�b�N
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
// �ʊJ�É��̃`�F�b�N
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
// �ʊJ�É��̃`�F�b�N
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
// �ʊJ�É��̃`�F�b�N
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
// ���D�̂݃`�F�b�N�{�^���̈ꊇ�`�F�b�N
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
// �}�C���X�g�o�^����
//
// kore :object�̖���
// param:�}�C���X�g�o�^�E�폜pgm�ɓn������
// rld  :�����[�h�v��
// param:���X�g�敪�i�����[�h���̂ݎg�p�j
/*------------------------------------------------*/
function MListIns(kore, param, rld, lstkbn, subsys) {
	// �`�F�b�N�a�n�w�̃��\�b�h��ϐ��Ɋ��蓖��
	elm = document.form1.elements[kore];

	// �Z�b�V�����h�c���擾����
	sid = "PHPSESSID=" + document.form1.elements["PHPSESSID"].value;
	val = "premylst01.jsp?" + sid + "&param=" + param + (elm.checked ? "1":"0");
	if (subsys == "TRI_"){
		opener.opener.top.B.location.href = val;
	}else{
		opener.top.B.location.href = val;
	}

	// ��ʂ̃����[�h�v��
	if (rld){
		document.form1.action = "premylst02.jsp?" + sid + "&lstkbn=" + lstkbn;
		document.form1.target = "_self";
		window.setTimeout("document.form1.submit()", 50);
	}
}

/*------------------------------------------------*/
// �}�C���X�g�o�^����@���ڍ׉�ʗp
//
// param:�}�C���X�g�o�^�ɓn������
/*------------------------------------------------*/
function MListInsDtl(param) {

	// �Z�b�V�����h�c���擾����
	sid = document.form1.elements["sessid"].value;
	val = "premylst01.jsp?" + sid + "&param=" + param + "1";
	opener.top.B.location.href = val;
}

/*------------------------------------------------*/
// ����}�C���X�g�o�^����
//
// kore :object�̖���
// param:�}�C���X�g�o�^�E�폜pgm�ɓn������
// rld  :�����[�h�v��
// param:���X�g�敪�i�����[�h���̂ݎg�p�j
/*------------------------------------------------*/
function MListInfIns(kore, param, rld, lstkbn, subsys) {
	// �`�F�b�N�a�n�w�̃��\�b�h��ϐ��Ɋ��蓖��
	elm = document.form1.elements[kore];

	// �Z�b�V�����h�c���擾����
	sid = "PHPSESSID=" + document.form1.elements["PHPSESSID"].value;
	val = "premyinf01.jsp?" + sid + "&param=" + param + (elm.checked ? "1":"0");
	//window.alert(subsys);
	if ((subsys != "INF") && (subsys != "IML")){
		opener.opener.top.B.location.href = val;
	}else{
		opener.top.B.location.href = val;
	}

	// ��ʂ̃����[�h�v��
	if (rld){
		document.form1.action = "premyinf02.jsp?" + sid + "&lstkbn=" + lstkbn;
		document.form1.target = "_self";
		window.setTimeout("document.form1.submit()", 50);
	}
}

/*------------------------------------------------*/
// ����}�C���X�g�o�^����@���ڍ׉�ʗp
//
// param:�}�C���X�g�o�^�ɓn������
/*------------------------------------------------*/
function MListInfInsDtl(param) {

	// �Z�b�V�����h�c���擾����
	sid = document.form1.elements["sessid"].value;
	val = "premyinf01.jsp?" + sid + "&param=" + param + "1";
	opener.top.B.location.href = val;
}

/*------------------------------------------------*/
// �߂�
/*------------------------------------------------*/
function Historyback(){

	history.back();
}

/*------------------------------------------------*/
// �o�iNO���̓G���A�̃N���A
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
// ���N�G�X�g�T�[�r�X����
//
// kore  : object�̖���
// param : ���N�G�X�g����v���O�����ɓn������
// rld   : �����[�h�v��
/*------------------------------------------------*/
function RqProcCtl(kore, param, rld) {

	// �`�F�b�N�a�n�w�̃��\�b�h��ϐ��Ɋ��蓖��
	elm = document.form1.elements[kore];

	// �Z�b�V�����h�c���擾����
	sid = document.form1.elements["sessid"].value;
	val = "prerqcnd02.jsp?" + sid + "&param=" + param;
	opener.top.B.location.href = val;

	// ��ʂ̃����[�h�v��
	if (rld){
		document.form1.action = "prerqcnd01.jsp?" + sid + '&fnc=back';
		document.form1.target = "_self";
		window.setTimeout("document.form1.submit()", 50);
	}

}

/*------------------------------------------------*/
// �Z���N�g�{�b�N�X���̍��ڒǉ�
//
// obj    : object�̖���
// list   : �Z���N�g�{�b�N�X1 �I�����鑤
// select : �Z���N�g�{�b�N�X2 �I����������
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
// �Z���N�g�{�b�N�X���̍��ڍ폜
//
// obj    : object�̖���
// select : �Z���N�g�{�b�N�X2 �I����������
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
// JavaScript�ɂ�郊���N�֐�
//
// url    : �����N��y�[�W
//------------------------------------------------
function JSPageLocation( url, flg ){
	if (flg) {
		// �v���g�R���ݒ�
		var prtclstr = window.location.protocol;
		re = new RegExp('https', 'i');
		if (prtclstr.match(re)) {
			prtclstr = 'https://';
		} else {
			prtclstr = 'http://';
		}
		// �z�X�g���ݒ�
		var hostname = window.location.host;
		// �p�X���ݒ�
		var pathname = window.location.pathname;
		var searchlength = pathname.lastIndexOf('/');
		if (0 >= searchlength) {
			searchlength = length(pathname);
		}
		pathname = pathname.substr(0, (searchlength + 1));

		// �y�[�W�����N������
		window.location.href = prtclstr+hostname+pathname+url;
	} else {
	document.forms[0].action = url;
	document.forms[0].target = '_self';
	document.forms[0].submit();
	}
}

/*------------------------------------------------*/
// �}�C���X�g�o�^����
//
// chkbox:object�̖���
// href: �}�C���X�g�o�^�E�폜URL
/*------------------------------------------------*/
function MListIns2(chkbox, href){
	elm = document.form1.elements[chkbox];
	val = href + "&action=" + (elm.checked ? "insert" : "delete");
	document.location.href = val;
}

/*------------------------------------------------*/
// ���N�G�X�g�T�[�r�X����
//
// chkbox:object�̖���
// href: �폜�E����URL
/*------------------------------------------------*/
function RqProcCtl2(href){
	document.location.href = href;
}

/*------------------------------------------------*/
// �I�[�v���E�C���h�E����
//
// url: �f�[�^���M��URL
// name: �E�B���h�E��
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


// String�N���X��Trim���\�b�h�̒ǉ�
String.prototype.trim = function() {
    return this.replace(/^[ ]+|[ ]+$/g, '');
}
