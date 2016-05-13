var formstr = {//comfirm string
  temail:function(str){
      var temail = new RegExp("^[0-9a-zA-Z._-]+@[0-9a-zA-Z-]+\.[0-9a-zA-Z]+(\.[0-9a-zA-Z]+){0,1}$");
      if(temail.test(str)){
	return true;
      }
      return false;
  },
  tmenuname:function(str){/*检验按钮名称长度1-16(中文8位，英文16位)*/
      var byteLen = 0, len = str.length;
      if( !str ) return 0;
      for( var i=0; i<len; i++ )
	  byteLen += str.charCodeAt(i) > 255 ? 2 : 1;
      if( byteLen > 0&& byteLen <=16)
	    return true;
      return false;
  },
  turl:function(str){
      var tname = new RegExp("^.{1,1000}$");
      if(tname.test(str)){
	return true;
      }
      return false;
  },
  ttype:function(str){
    var tname = new RegExp("^.{1,50}$");
    if(tname.test(str)){
	if(str != "0")
	      return true;
      }
      return false;
  },
  tname:function(str){
    var tname = new RegExp("^.{1,20}$");
    if(tname.test(str)){
	return true;
      }
      return false;
  },
  tnonull:function(str){
    var tname = new RegExp("^.{1,50}$");
    if(tname.test(str)){
	return true;
      }
      return false;
  },
  tnonull2:function(str){
    var tname = new RegExp("^.{1,300}$");
    if(tname.test(str)){
	return true;
      }
      return false;
  },
  tinfostr:function(str){
    var tname = new RegExp("^.{8,100}$");
    if(tname.test(str)){
	return true;
      }
      return false;
  },
  ttoken:function(str){
     var tname = new RegExp("^[0-9a-zA-Z]{3,32}$");
     if(tname.test(str)){
	return true;
      }
      return false;
  },
  tAesKey:function(str){
    var tname = new RegExp("^[0-9a-zA-Z]{43}$");
     if(tname.test(str)){
	return true;
      }
      return false;
  },

}

var fileupload = {
  sendfiles:function(data, obj){
	var self=this;
  popup.openprogress();
	var formData = new FormData();
	var xhr = new XMLHttpRequest();
	formData.append("uploadfile",data);
	xhr.open ('POST',"/adminapi/uploadimage/");
	xhr.onload = function(event) {
    popup.closeprogress();
    if (xhr.status === 200) {
      var aa = JSON.parse(xhr.responseText);
      if(aa.code == '10'){
        fileupload.replaceinput(aa.path,obj);
        popup.openwarning('upload success');
        return true;
      }
      popup.openwarning(aa.msg);
    } else {
      popup.openwarning('upload error');
    }
  };
    xhr.upload.onprogress = self.updateProgress;
    xhr.send (formData);
  },
  updateProgress:function(event){
    if (event.lengthComputable){
        var percentComplete = event.loaded;
        var percentCompletea = event.total;
        var press = (percentComplete*100/percentCompletea).toFixed(2);//onprogress show
      	popup.goprogress(press);
    }
  },
  replaceinput:function(url ,obj){
    var a= '<i class="fa fa-times"></i><img src="'+url+'" style="width:200px;display:block;" class="newspic">';
    obj.after(a);
    obj.remove();
  },
  replaceimage:function(obj){
    var a = '<input type="file" name="uploadfile" class="newsfile">';
    obj.next().remove();
    obj.after(a);
    obj.remove();
  }
}

var popup = {
  openprogress:function(){
    $("#myprogress").show();
  },
  closeprogress:function(){
    $("#myprogress").hide();
  },
  goprogress:function(t){
    $("#myprogress .progress-bar").attr("aria-valuenow" ,t);
    $("#myprogress .progress-bar").css("width", t+"%");
    $("#myprogress .sr-only").text(t+"%");
  },
  openwarning:function(text){
    var a = '<div>'+text+'</div>';
    a += '<div><button type="button" onclick="popup.closewarning()" class="btn btn-default btn-sm">TRUE</button></div>';
    $("#warningpopup>.warningpopup").append(a);
    $("#warningpopup").show();
  },
  closewarning:function(){
    $("#warningpopup>.warningpopup").empty();
    $("#warningpopup").hide();
  },
  opencomfirm:function(text,fun){
    var a = '<div>'+text+'</div>';
    a += '<div>';
    a += '<button type="button" onclick="popup.closecomfirm()" class="btn btn-default btn-sm">CANCEL</button>&nbsp;&nbsp;';
    a += '<button type="button" onclick="'+fun+'" class="btn btn-primary btn-sm">TRUE</button>';
    a += '</div>';
    $("#comfirmpopup > .comfirmpopup").html(a);
    $("#comfirmpopup").show();
  },
  closecomfirm:function(){
    $("#comfirmpopup>.comfirmpopu").empty();
    $("#comfirmpopup").hide();
  },
  openloading:function(){
    $("#loadingpopup").show();
  },
  closeloading:function(){
    $("#loadingpopup").hide();
  }
}


var htmlconetnt = {
  externalpage:function(){
    var a = '<br>';
    a += '<div class="form-group">';
    a += '<label>Redirect to:</label>';
    a += '<input class="form-control viewurl" placeholder="Enter Your Url" style="width:90%">';
    a += '</div>';
    return a;
  },
  pushmessage:function(){
    var a = '<br>';
        a += '<div class="newslist">';
        a += '<i class="fa fa-minus-square" style="color:red"></i>';
        a += '<div class="form-group">';
        a += '<label>Title:</label>';
        a += '<input class="form-control newstitle" placeholder="Enter TITLE" style="width:90%">';
        a += '</div>';
        a += '<div class="form-group">';
        a += '<label>Description:</label>';
        a += '<input class="form-control newsdescription" placeholder="Enter Your Url" style="width:90%">';
        a += '</div>';
        a += '<div class="form-group">';
        a += '<label>Link:</label>';
        a += '<input class="form-control newslink" placeholder="Enter Your Url" style="width:90%" name="link">';
        a += '</div>';
        a += '<div class="form-group">';
        a += '<label>Cover:</label>';
        a += '<input type="file" name="uploadfile" class="newsfile">';
        a += '</div>';
        a += '<hr>';
        a += '</div>';
        a += '<i class="fa fa-plus-square" style="color:green"></i>';
    return a;
  },
  textmessage:function(){
      var a = '<br>';
        a += '<div class="form-group">';
        a += '<label>MESSAGE</label>';
        a += '<textarea class="form-control textcontent" rows="3"></textarea>';
        a += '</div>';
    return a;
  },
  addnewshtml:function(){
    var a = '<div class="newslist">';
        a += '<i class="fa fa-minus-square" style="color:red"></i>';
        a += '<div class="form-group">';
        a += '<label>Title:</label>';
        a += '<input class="form-control newstitle" placeholder="Enter TITLE" style="width:90%">';
        a += '</div>';
        a += '<div class="form-group">';
        a += '<label>Description:</label>';
        a += '<input class="form-control newsdescription" placeholder="Enter Your Url" style="width:90%">';
        a += '</div>';
        a += '<div class="form-group">';
        a += '<label>Link:</label>';
        a += '<input class="form-control newslink" placeholder="Enter Your Url" style="width:90%" name="link">';
        a += '</div>';
        a += '<div class="form-group">';
        a += '<label>Cover:</label>';
        a += '<input type="file" name="uploadfile" class="newsfile">';
        a += '</div>';
        a += '<hr>';
        a += '</div>';
        a += '<i class="fa fa-plus-square" style="color:green"></i>';
    return a;
  },
  belongtohtml:function(data){
    var a = "";
    var la = data.length;
    for (var i in data){
      a += '<option value="'+i+'">'+data[i]+'</option>';
    }
    return a;
  }
}

var menu = {
  mbuttonfun:null,
  subbuttonfun:null,
  delobj:null,
  showfeedback: function(obj){//add menu
    var self = this;
    var action = obj.attr('action');
    if($("#myModal ."+action+" div").length == 0)
      $("#myModal ."+action).html(htmlconetnt[action]());
    $("#myModal .menushow").removeClass("menushow");
    $("#myModal ."+action).addClass("menushow");
    self.mbuttonfun = "m"+action;
  },
  showfeedback2: function(obj){//add submenu
    var action = obj.attr('action');
    if($("#submenu ."+action+" div").length == 0)
      $("#submenu ."+action).html(htmlconetnt[action]());
    $("#submenu .menushow").removeClass("menushow");
    $("#submenu ."+action).addClass("menushow");
    self.subbuttonfun = "sub"+action;
  },
  mnone:function(){
    var a={
      "buttonaddm[menuName]": $("#myModal .menuname").val(),
    };
    return a;
  },
  mexternalpage:function(){
    var a={
      "buttonaddm[menuName]": $("#myModal .menuname").val(),
      "buttonaddm[eventtype]": 'view',
      "buttonaddm[eventUrl]": $("#myModal .viewurl").val(),
    };
    return a;
  },
  mpushmessage:function(){
    var self = this;
    var key = new Date().getTime();
    var a = {
      "buttonaddm[menuName]": $("#myModal .menuname").val(),
      "buttonaddm[eventtype]": 'click',
      "buttonaddm[MsgType]": 'news',
      "buttonaddm[eventKey]": "e"+key,
      "buttonaddm[newslist]": self.getnewslist($("#myModal .pushmessage .newslist")),
    };
    return a;
  },
  getnewslist:function(obj){
    var a = [];
    var la = obj.length;
    obj.each(function(){
      var mself = $(this);
      var b = {};
      b = {
        "Title": mself.find(".newstitle").val(),
        "Description": mself.find(".newsdescription").val(),
        "Url": mself.find(".newslink").val(),
        "PicUrl": mself.find(".newspic").attr("src"),
      }
      a.push(b);
    });
    return JSON.stringify(a);
  },
  mtextmessage:function(){
    var key = new Date().getTime();
    var a={
      "buttonaddm[menuName]":$("#myModal .menuname").val(),
      "buttonaddm[eventtype]":'click',
      "buttonaddm[Content]": $("#myModal .textcontent").val(),
      "buttonaddm[MsgType]": 'text',
      "buttonaddm[eventKey]": "e"+key,
    };
    return a;
  },
  subnone:function(){
    var a={
      "buttonaddm[menuName]": $("#myModal .menuname").val(),
    };
    return a;
  },
  subexternalpage:function(){
    var a={
      "buttonaddm[menuName]": $("#myModal .menuname").val(),
      "buttonaddm[eventtype]": 'view',
      "buttonaddm[eventUrl]": $("#myModal .viewurl").val(),
    };
    return a;
  },
  subpushmessage:function(){
    var self = this;
    var key = new Date().getTime();
    var a = {
      "buttonaddm[menuName]": $("#myModal .menuname").val(),
      "buttonaddm[eventtype]": 'click',
      "buttonaddm[MsgType]": 'news',
      "buttonaddm[eventKey]": "e"+key,
      "buttonaddm[newslist]": self.getnewslist($("#myModal .pushmessage .newslist")),
    };
    return a;
  },
  subtextmessage:function(){
    var key = new Date().getTime();
    var a={
      "buttonaddm[menuName]":$("#myModal .menuname").val(),
      "buttonaddm[eventtype]":'click',
      "buttonaddm[Content]": $("#myModal .textcontent").val(),
      "buttonaddm[MsgType]": 'text',
      "buttonaddm[eventKey]": "e"+key,
    };
    return a;
  },
  cleaninput:function(obj){
    obj.each(function(){
      $(this).val("");
    });
  },
  ajaxaddmbutton:function(){
    popup.openloading();
    var self = this;
    var up = menu[self.mbuttonfun]();
    $.ajax({
      type:'post',
      url: '/adminapi/addmbutton/',
      data: up,
      dataType:'json',
      success: function(data){
        popup.closeloading();
        if(data.code == '10'){
          menu.cleaninput($("#myModal input"));
          $('#myModal').modal('hide');
          popup.openwarning(data.msg);
          menu.ajaxreload();
          return true;
        }
        popup.openwarning(data.msg);
      },
      error:function(){
        popup.closeloading();
        menu.ajaxreload();
        popup.openwarning('unknow error');
      }
    });
  },
  ajaxreload:function(){
    $.ajax({
      type:"post",
      url: "/adminapi/getmenus/",
      dataType:"json",
      success: function(data){
        menu.buildtd(data['menus']);
      },
      error:function(){
        popup.openwarning('unknow error');
      },
    });
  },
  buildtd:function(data){
    var la = data.length;
    var a = "";
    for(var i=0 ;i<la ;i++){
      a += '<tr class="odd gradeX" menuid="'+data[i]['id']+'">';
      a += '<td>'+data[i]['menuName']+'</td>';
      a += '<td>'+data[i]['belongto']+'</td>';
      a += '<td>'+data[i]['eventtype']+'</td>';
      a += '<td class="center"><i class="fa fa-edit fa-lg"></i></td>';
      a += '<td class="center"><i class="fa fa-trash-o fa-lg"></i></td>';
      a +='</tr>';
    }
    $("#menutable tbody").html(a);
  },
  delbutton: function(){
    obj = this.delobj;
    var id = obj.parent().parent().attr('menuid');
    popup.openloading();
    $.ajax({
      type:'post',
      url: '/adminapi/deletebutton/',
      dataType:'json',
      data: {
          "buttondel[id]": id,
        },
      success: function(data){
        popup.closeloading();
        if(data.code == '10'){
          popup.closecomfirm();
          menu.ajaxreload();
          popup.openwarning(data.msg);
          return true;
        }
        popup.openwarning(data.msg);
      },
      error:function(){
        popup.closeloading();
        popup.openwarning('unknow error');
      }
    });
  },
  publishmenu:function(){
    popup.openloading();
    $.ajax({
      url:"/adminapi/createmenu/",
      type:"post",
      dataType:'json',
      success:function(data){
        popup.closeloading();
        if(data.code == '10'){
          popup.openwarning(data.msg);
          return true;
        }
        popup.openwarning(data.msg);
      },
      error:function(){
        popup.closeloading();
        popup.openwarning('unknow errors');
      }
    });
  },
  ajaxgetmbuttom:function(){
    popup.openloading();
    $.ajax({
      url:"/adminapi/getmmenu/",
      type:"post",
      dataType:'json',
      success:function(data){
        popup.closeloading();
        if(data.code == '10'){
          $("#submenu .belongto").html(htmlconetnt.belongtohtml(data.menus));
          $('#submenu').modal('show');
          return true;
        }
      },
      error:function(){
        popup.closeloading();
        popup.openwarning('unknow errors');
      }
    });
  },
  onload: function(){
    var self = this;
    $("#myModal .buttontype .btn").click(function(){//add main menu 's submenu
      $("#myModal .buttontype .active").removeClass("active");
      $(this).addClass("active");
      self.showfeedback($(this));
    });
    $("#menufun>.addmainmenu").click(function(){//add main menu
      if(!self.mbuttonfun)
        self.mbuttonfun = "mnone";
      $('#myModal').modal('show');
    });
    $("#menufun>.addsubmenu").click(function(){//add main menu ajax
      self.ajaxgetmbuttom();
    });
    $("#submenu .buttontype .btn").click(function(){//add main menu 's submenu
      $("#submenu .buttontype .active").removeClass("active");
      $(this).addClass("active");
      self.showfeedback2($(this));
    });
    $("#myModal .addmmenusubmit").click(function(){
      self.ajaxaddmbutton();
    });
    $("#menufun>.publish").click(function(){
      self.publishmenu();
    });
    $("#menutable").on("click", "tbody .fa-trash-o", function(){
      self.delobj = $(this);
      popup.opencomfirm("delete this menu???","menu.delbutton()");
    });
    $("#myModal").on("click",".fa-minus-square", function(){
      $(this).parent().remove();
    });
    $("#myModal").on("click",".fa-plus-square", function(){
      var a = htmlconetnt.addnewshtml();
      $(this).after(a);
      $(this).remove();
      if($("#myModal .pushmessage .fa-minus-square").length >= 10)
        $("#myModal .pushmessage .fa-plus-square").remove();
    });
    $("#myModal").on("change", ".newsfile", function(){
      fileupload.sendfiles($(this)[0].files[0], $(this));
    });
    $("#myModal").on("click",".fa-times",function(){
      fileupload.replaceimage($(this));
    });
  },
}

var keyword = {
  showaddedit: function(obj){
    var action = obj.attr('action');
    if($("#addkeyword ."+action+" div").length == 0)
      $("#addkeyword ."+action).html(htmlconetnt[action]());
    $("#addkeyword .menushow").removeClass("menushow");
    $("#addkeyword ."+action).addClass("menushow");
  },
  onload: function(){
    var self = this;
    $("#menufun>.addkeyword").click(function(){
      $("#addkeyword").modal('show');
    });
    $("#addkeyword .buttontype .btn").click(function(){//add main menu 's submenu
      $("#addkeyword .buttontype .active").removeClass("active");
      $(this).addClass("active");
      self.showaddedit($(this));
    });
  }
}

var autoreplay = {
  showwelcome: function(obj){
    var action = obj.attr('action');
    if($("#welcomemessage ."+action+" div").length == 0)
      $("#welcomemessage ."+action).html(htmlconetnt[action]());
    $("#welcomemessage .menushow").removeClass("menushow");
    $("#welcomemessage ."+action).addClass("menushow");
  },
  showdefault:function(obj){
    var action = obj.attr('action');
    if($("#defaultmessage ."+action+" div").length == 0)
      $("#defaultmessage ."+action).html(htmlconetnt[action]());
    $("#defaultmessage .menushow").removeClass("menushow");
    $("#defaultmessage ."+action).addClass("menushow");
  },
  onload: function(){
    var self = this;
    $("#autoreplaynav .message").click(function(){
      $("#autoreplaynav .active").removeClass("active");
      $(this).parent().addClass("active");
      $("#autoreload .navshow").removeClass("navshow");
      var active = $(this).attr("active");
      $("#"+active).addClass("navshow");
    });
    $("#welcomemessage .buttontype>.btn").click(function(){
      $("#welcomemessage .buttontype .active").removeClass("active");
      $(this).addClass("active");
      self.showwelcome($(this));
    });
    $("#defaultmessage .buttontype>.btn").click(function(){
      $("#defaultmessage .buttontype .active").removeClass("active");
      $(this).addClass("active");
      self.showdefault($(this));
    });
  }
}

var preference = {
  onload: function(){
    var self = this;
    $("#preferencenav .message").click(function(){
      $("#preferencenav .active").removeClass("active");
      $(this).parent().addClass("active");
      $("#preference .navshow").removeClass("navshow");
      var active = $(this).attr("active");
      $("#"+active).addClass("navshow");
    });
  }
}

var webpage = {
  onload: function(){
    $("#pagmanagenav .message").click(function(){
      $("#pagmanagenav .active").removeClass("active");
      $(this).parent().addClass("active");
      $("#pagmanage .navshow").removeClass("navshow");
      var active = $(this).attr("active");
      $("#"+active).addClass("navshow");
    });
  }
}

$(function(){
  menu.onload();
  keyword.onload();
  autoreplay.onload();
  preference.onload();
  webpage.onload();
});
