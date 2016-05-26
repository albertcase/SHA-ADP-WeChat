CKEDITOR.plugins.add( 'dropmenuckedit',
    {
        init : function( editor )
        {
    
            // Register the command.
            editor.addCommand( 'dropmenuckedit',{
                exec : function( editor )
                {
                    editor.insertHtml('<pre class="brush:php; toolbar: true; auto-links: false;" style="font-size:12px">//php脚本开始</pre>');
                }
            });
            alert('dedephp!');
            // Register the toolbar button.
            editor.ui.addButton( 'dropmenuckedit',
            {
                label : '插入PHP代码',
                command : 'dropmenuckedit',
                icon: 'images/noimage.png'
            });
            alert(editor.name);
        },
    });
