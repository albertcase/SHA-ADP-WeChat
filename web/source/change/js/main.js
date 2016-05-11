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


var htmlconetnt = {
  externalpage:function(){
    var a = '<br>';
    a += '<div class="form-group">';
    a += '<label>Redirect to:</label>';
    a += '<input class="form-control" placeholder="Enter Your Url" style="width:90%">';
    a += '</div>';
    return a;
  },
  pushmessage:function(){
    var a = '<br>';
        a += '<div class="newslist">';
        a += '<i class="fa fa-minus-square" style="color:red"></i>';
        a += '<div class="form-group">';
        a += '<label>Title:</label>';
        a += '<input class="form-control" placeholder="Enter TITLE" style="width:90%">';
        a += '</div>';
        a += '<div class="form-group">';
        a += '<label>Description:</label>';
        a += '<input class="form-control" placeholder="Enter Your Url" style="width:90%">';
        a += '</div>';
        a += '<div class="form-group">';
        a += '<label>Link:</label>';
        a += '<input class="form-control" placeholder="Enter Your Url" style="width:90%" name="link">';
        a += '</div>';
        a += '<div class="form-group">';
        a += '<label>Cover:</label>';
        a += '<input type="file" name="uploadfile">';
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
        a += '<textarea class="form-control" rows="3"></textarea>';
        a += '</div>';
    return a;
  }

}

var menu = {
  showfeedback: function(obj){//add menu
    var action = obj.attr('action');
    if($("#myModal ."+action+" div").length == 0)
      $("#myModal ."+action).html(htmlconetnt[action]());
    $("#myModal .menushow").removeClass("menushow");
    $("#myModal ."+action).addClass("menushow");
  },
  showfeedback2: function(obj){//add submenu
    var action = obj.attr('action');
    if($("#submenu ."+action+" div").length == 0)
      $("#submenu ."+action).html(htmlconetnt[action]());
    $("#submenu .menushow").removeClass("menushow");
    $("#submenu ."+action).addClass("menushow");
  },
  onload: function(){
    var self = this;
    $("#myModal .buttontype .btn").click(function(){//add main menu 's submenu
      $("#myModal .buttontype .active").removeClass("active");
      $(this).addClass("active");
      self.showfeedback($(this));
    });
    $("#menufun>.addmainmenu").click(function(){//add main menu
      $('#myModal').modal('show');
    });
    $("#menufun>.addsubmenu").click(function(){//add main menu
      $('#submenu').modal('show');
    });
    $("#submenu .buttontype .btn").click(function(){//add main menu 's submenu
      $("#submenu .buttontype .active").removeClass("active");
      $(this).addClass("active");
      self.showfeedback2($(this));
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
