CKEDITOR.plugins.add( 'myPreview',
    {
        init : function( editor )
        {

            // Register the command.
            editor.addCommand( 'myPreview',{
                exec : function( editor )
                {
                    var doc = window.open('','_blank');
                    doc.document.write('<link type="text/css" rel="stylesheet" href="/source/ckeditor/contentsmy.css">');
                    doc.document.write('<style type="text/css">iframe{width:100%}.droptag1{background:url(/source/change/img/droptag1.png)!important;background-repeat:no-repeat!important;background-size:100% 100%!important}.dropmenuckedit{width:100%;margin-top:20px;margin-bottom:20px}.dropmenuckedit>div:nth-child(1){width:80%;margin:0 auto;height:68px;line-height:68px;font-size:60px;padding:20px;padding-top:20px;padding-bottom:20px;background:url(/source/change/img/droptag2.png);background-repeat:no-repeat;background-size:100% 100%}.dropmenuckedit>div:nth-child(1)~div{width:90%;margin:0 auto;display:none}</style>');
                    doc.document.write('<script type="text/javascript" src="/source/manage/js/jquery-1.11.0.js"></script>');
                    doc.document.write('<p><img src="/source/change/img/adp1.png" style="width:100%"></p>');
                    doc.document.write( CKEDITOR.instances.editor1.getData() );
                    doc.document.write('<p><img src="/source/change/img/adp2.png" style="width:100%"></p>');
                    doc.document.write('<script>$(".dropmenuckedit>div:nth-child(1)").click(function(){  $(this).nextAll().toggle();  if($(this).is(".droptag1")){    $(this).removeClass("droptag1");  }else{    $(this).addClass("droptag1");  }});</script>');
                  	doc.focus();
                }
            });
            // alert('dedephp!');
            // Register the toolbar button.
            editor.ui.addButton( 'myPreview',
            {
                label : 'myPreview',
                command : 'myPreview',
                icon: 'images/html_add.png'
            });
            // alert(editor.name);
        },
    });
