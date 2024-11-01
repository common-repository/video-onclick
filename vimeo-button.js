(function() {
    tinymce.create('tinymce.plugins.vimeo', {
        init : function(ed, url) {
            ed.addButton('vimeo', {
                title : 'Vimeo',
                image : url+'/vimeo.png',
                onclick : function() {
                    idPattern = /([0-9a-z]+)\/([0-9a-z]+)/;
                    var vidId = prompt("Vimeo video", "Enter the id or url for your video");
                    var m = idPattern.exec(vidId);
                    if (m != null && m != 'undefined')
                        ed.execCommand('mceInsertContent', false, '[vimeo]'+m[2]+'[/vimeo]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Video Onclick Vimeo",
                author : 'Igor Tesliuk',
                authorurl : 'http://tigor.org.ua/',
                infourl : 'http://tigor.org.ua/video-onclick',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('vimeo', tinymce.plugins.vimeo);
})();