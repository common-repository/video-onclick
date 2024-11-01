function inline_voutub( id )
	{
	var divTag = document.createElement("div");

    divTag.id = "youtube_"+id;
	
	divTag.innerHTML = '<div class="video-onclick-inline"><div class="video-onclick-close" onClick="closevoutub('+"'"+id+"'"+')">'+videoclosetext()+'</div><div class="video-onclick-content"><object style="height: 390px; width: 640px"><param name="movie" value="http://www.youtube.com/v/'+id+'?version=3&autoplay=1"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><embed src="http://www.youtube.com/v/'+id+'?version=3&autoplay=1" type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" width="640" height="390"></object></div><div class="video-onclick-info">'+videoinfo(id)+'</div></div>';
	var youtube = 'video-onclick-'+id;
	document.getElementById(youtube).appendChild(divTag);
	document.getElementById(id).style.display = 'none';
	}

function inline_vovimeo( id )
	{
	var divTag = document.createElement("div");
	
    divTag.id = "vimeo_"+id;
	divTag.innerHTML = '<div class="video-onclick-inline"><div class="video-onclick-close" onClick="closevovimeo('+"'"+id+"'"+')">'+videoclosetext()+'</div><div class="video-onclick-content"><iframe src="http://player.vimeo.com/video/'+id+'?autoplay=1" width="640" height="360" frameborder="0"></iframe></div><div class="video-onclick-info">'+videoinfo(id)+'</div></div>';
	
	
	
	var vimeo = 'video-onclick-'+id;
	document.getElementById(vimeo).appendChild(divTag);
	document.getElementById(id).style.display = 'none';
	}
	

function voutub(id)
	{

            var divTag = document.createElement("div");

            divTag.id = "youtube_"+id;

            divTag.className = "video-onclick-wrap";

            divTag.innerHTML = '<div class="video-onclick-main"><div class="video-onclick-close" onClick="closevoutub('+"'"+id+"'"+')">'+videoclosetext()+'</div><div class="video-onclick-content"><object style="height: 390px; width: 640px"><param name="movie" value="http://www.youtube.com/v/'+id+'?version=3&autoplay=1"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><embed src="http://www.youtube.com/v/'+id+'?version=3&autoplay=1" type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" width="640" height="390"></object></div><div class="video-onclick-info">'+videoinfo(id)+'</div></div>';
			
            document.body.appendChild(divTag);
			
			if(typeof window.VideoOnclickHook == 'function') {

				VideoOnclickHook(id);
			}
  	}

	
function closevoutub(id)
	{
	var youtube = "youtube_"+id;
	var element = document.getElementById(youtube);
	element.parentNode.removeChild(element);
	document.getElementById(id).style.display = '';
	
	}
	

function vovimeo( id )
	{
	
			var divTag = document.createElement("div");

            divTag.id = "vimeo_"+id;

            divTag.className = "video-onclick-wrap";

            divTag.innerHTML = '<div class="video-onclick-main"><div class="video-onclick-close" onClick="closevovimeo('+"'"+id+"'"+')">'+videoclosetext()+'</div><div class="video-onclick-content"><iframe src="http://player.vimeo.com/video/'+id+'?autoplay=1" width="640" height="360" frameborder="0"></iframe></div><div class="video-onclick-info">'+videoinfo(id)+'</div></div>';

            document.body.appendChild(divTag);
			if(typeof window.VideoOnclickHook == 'function') {

				VideoOnclickHook(id);
			}
	
	
	}	
	
function closevovimeo( id )
	{
	document.getElementById(id).style.display = '';
	
	var vimeo = "vimeo_"+id;
	var element = document.getElementById(vimeo);
	element.parentNode.removeChild(element);
	
	
	}