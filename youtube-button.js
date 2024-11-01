(function() {
    tinymce.create('tinymce.plugins.youtube', {
        init : function(ed, url) {
            ed.addButton('youtube', {
                title : 'YouTube',
                image : url+'/youtube.png',
                onclick : function() {
                    idPattern = /(?:(?:[^v]+)+v.)?([^&=]{11})(?=&|$)/;
                    var vidId = prompt("YouTube Video", "Enter the id or url for your video");
                    var m = idPattern.exec(vidId);
                    if (m != null && m != 'undefined')
                        ed.execCommand('mceInsertContent', false, '[youtube]'+m[1]+'[/youtube]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Video Onclick YouTube",
                author : 'Igor Tesliuk',
                authorurl : 'http://tigor.org.ua/',
                infourl : 'http://tigor.org.ua/video-onclick',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('youtube', tinymce.plugins.youtube);
})();