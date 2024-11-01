<?php
/*
Plugin Name: Video Onclick
Plugin URI: http://tigors.net/en/en-video-onclick/
Description: Inserts video code only when user clicks on Play picture. Reduces load time on pages with many videos.  
Version: 0.4.7 
Author: TIgor
Author URI: http://tigors.net
License: GPL2
*/


/*  Copyright 2011-2012 Tesliuk Igor  (email : tigor@tigors.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
	function video_onclick_jscript(){
	$options = get_option('video_onclick_options');
	?>
	<script type="text/javascript" src="<?php echo plugins_url() ?>/video-onclick/video-onclick.js?v=1">
	
	</script>
	<script type="text/javascript">

	function videoinfo(id) {
		return '<?php
			echo str_replace(array("\n","\r\n"), '',$options['info']);
		?>';
	}
	
	function videoclosetext() {
	return '<?php
		if ($options['info']) {
			echo str_replace(array("\n","\r\n"), '',$options['close']);
		} else {
			echo 'Close(x)';
		}
	
	?>';
	}
	</script>
	<?php
	}

function youtube_shortcode($atts,$content)
	{
	$options = get_option('video_onclick_options');
	$youtube = video_onclick_youtube_info($content);
	$title = $youtube['title'];
	
	$width = $atts ['width'];
	$height = $atts ['height'];

	$ret = '';
	
	if ('' != $atts ['title']) 
	{
		$title = $atts ['title'];
	}
	
	if ('' == $width) 
	{
		$width = '640px';
	}
	
	if ('' == $height) 
	{
		$height = '390px';
	}
	
	if ('' != $atts ['play_img'])
	{
		$play = $atts ['play_img'];
	} else {
		$play = $options['play'];
	}
	
	
	
	if ((('true' == $atts['inline'])OR('true' == $options['inline'])) AND ('false' != $atts['inline']))
	{
		$onclick = "inline_voutub('".$content."')";
	} else {
		$onclick = "voutub('".$content."')";
	}
	
	
	
	$href = $options['href'];
	
	if ( $atts['href'] != '')
	{
		$href = $atts['href'];
	}
	
	if ('true' == $href )
	{
		$ret = '<a name="'.$content.'"></a><div id="video-onclick-'.$content.'"><a class="video-onclick-link"  href="#'.$content.'">'.$title.'</a><div title="'.$title.'" class="video-onclick-click-div" id="'.$content.'" style="width:'.$width.';height:'.$height.';background-image:url('."'".$youtube['thumb']."'".');"  onClick="'.$onclick.'"><img class="video-onclick-play-button" src="'.$play.'" / ></div></div>';
	} else {
	
		$ret = '<div id="video-onclick-'.$content.'"><div title="'.$title.'" class="video-onclick-click-div" id="'.$content.'" style="width:'.$width.';height:'.$height.';background-image:url('."'".$youtube['thumb']."'".');"  onClick="'.$onclick.'"><img class="video-onclick-play-button" src="'.$play.'" / ></div></div>';
	}
	
	return $ret;
}
	
function vimeo_shortcode($atts,$content)
	{
	$ret = '';
	$options = get_option('video_onclick_options');
	$vimeo = video_onclick_vimeo_info($content);
	$title = $vimeo['title'];
	
	$width = $atts ['width'];
	$height = $atts ['height'];
	
	if ('' != $atts ['title']) 
	{
		$title = $atts ['title'];
	}
	
	if ('' == $width) 
	{
		$width = '640px';
	}
	
	if ('' == $height) 
	{
		$height = '390px';
	}
	
	if ('' != $atts ['play_img'])
	{
		$play = $atts ['play_img'];
	} else {
		$play = $options['play'];
	}
	
	if ((('true' == $atts['inline'])OR('true' == $options['inline'])) AND ('false' != $atts['inline']))
	{
		$onclick = "inline_vovimeo('".$content."')";
	} else {
		$onclick = "vovimeo('".$content."')";
	}
	
	
	$href = $options['href'];
	if ( $atts['href'] != '')
	{
		$href = $atts['href'];
	}
	
	if ('true' == $href )
	{
		$ret = '<a name="'.$content.'"></a><div id="video-onclick-'.$content.'"><a class="video-onclick-link" href="#'.$content.'">'.$title.'</a><div title="'.$title.'" class="video-onclick-click-div" id="'.$content.'" style="width:'.$width.';height:'.$height.';background-image:url('."'".$vimeo['thumb']."'".');"  onClick='.$onclick.'><img class="video-onclick-play-button" src="'.$play.'" / ></div></div>';
	} else {
		$ret = '<div id="video-onclick-'.$content.'"><div title="'.$title.'" class="video-onclick-click-div" id="'.$content.'" style="width:'.$width.';height:'.$height.';background-image:url('."'".$vimeo['thumb']."'".');"  onClick='.$onclick.'><img class="video-onclick-play-button" src="'.$play.'" / ></div></div>';
	}
	
	$ret = $ret + '';
	
	return $ret;
}
	
function video_onclick_java($plugin_array) {
   $plugin_array['youtube'] = plugins_url().'/video-onclick/youtube-button.js';
   $plugin_array['vimeo'] = plugins_url().'/video-onclick/vimeo-button.js';
   return $plugin_array;
	} 


function video_onclick_button($buttons) {
    array_push($buttons, 'youtube');
	array_push($buttons, 'vimeo');
    return $buttons;
     }

function video_onclick_init(){
	
	$options = get_option('video_onclick_options');
	
	add_shortcode( 'youtube', 'youtube_shortcode' );
	add_shortcode( 'vimeo', 'vimeo_shortcode' );
	add_action("wp_print_scripts", "video_onclick_jscript");
	add_filter('mce_buttons', 'video_onclick_button', 0);
	add_filter('mce_external_plugins', 'video_onclick_java');
	
	if (!$options['css'])
	{
		add_action('wp_print_styles', 'video_onclick_stylesheet');
	}
}

function video_onclick_stylesheet() {
        $myStyleUrl = WP_PLUGIN_URL . '/video-onclick/video-onclick.css';
        $myStyleFile = WP_PLUGIN_DIR . '/video-onclick/video-onclick.css';
        if ( file_exists($myStyleFile) ) {
            wp_register_style('myStyleSheets', $myStyleUrl);
            wp_enqueue_style( 'myStyleSheets');
        }
}

function options_video_onclick() {
	?>
	<form method="post" action="options.php"> 
	<h2>Video Onclick Settings</h2>
	<hr />
	<?php 
	settings_fields('video_onclick_group');
	$options = get_option('video_onclick_options');
	$errors = get_option('video_onclick_errors');
	

	
	$delete = $options['delete'];

	if (count($delete) > 0) 
	{

		for ($i=0; $i<count($delete); $i++) 
		{
		unset($errors[$delete[$i]]);
		
		$cache = get_option('video_onclick_cache');
		unset($cache[$delete[$i]]);
		update_option('video_onclick_cache',$cache);

		

		}
	update_option('video_onclick_options',$options);
	update_option('video_onclick_errors',$errors);
	}
	
	?>
	<h3>Info DIV</h3>
	This text will be printed with video.<br />
	<textarea style="width: 75%;"  name="video_onclick_options[info]" rows="10"><?php echo $options['info']; ?></textarea>
	
	<h3>Close DIV</h3>
	This text will be shown as close button.<br />
	<textarea style="width: 75%;" name="video_onclick_options[close]" /><?php echo $options['close']; ?></textarea>
	
	
	
	<h3>Play Image URL</h3>
	URL to the image it the center of the shortcode.<br />
	<input style="width: 75%;" type="text" value="<?php echo $options['play']; ?>" name="video_onclick_options[play]" />
	<h3>USE own CSS</h3>
	<INPUT NAME="video_onclick_options[css]" TYPE="CHECKBOX" VALUE="true" <?php if($options['css']){echo 'CHECKED';} ?>> Disable CSS provided by this plugin.
	<h3>Inline code</h3>
	<INPUT NAME="video_onclick_options[inline]" TYPE="CHECKBOX" VALUE="true" <?php if($options['inline']){echo 'CHECKED';} ?>>Do not use popup.
	<h3># Link to video on page</h3>
	<INPUT NAME="video_onclick_options[href]" TYPE="CHECKBOX" VALUE="true" <?php if($options['href']){echo 'CHECKED';} ?>> Add #link, pointing to video on page.
	<br />
	You can change this for each video individually, by adding parametr href=[true|false] in shortcode, for example [youtube href=true]id[/youtube]
	
	<?php
	
	
	?> <p class="submit">
    <input type="submit" class="button-primary" value="Save Changes" />
    </p>
	<h3>Errors</h3>
	These are videos, that had errors during parsing from youtube.(For last 72 hours)<br /><br />
	<table width="100%" style="text-align:center;">
	<tr >
		<td width="20px"><b>Delete?</b></td>
		<td width="40px"><b>Video ID</b></td>
		<td width="120px"><b>Http response code</b></td>
		<td><b>Post</b></td>
		<td width="120px"><b>Time when last ocured</b></td>
		
	</tr>
	<?php 
	if (count($errors) > 0)
	{
	$page_num = (int) $_GET['p'];
	$i = 1;
	if ($page_num == '')
	{
		$page_num = 1;
	}
	$pager = 'Pages: '.video_onclick_pager(count($errors),$page_num);
	 echo $pager;
	
	foreach ($errors as $error)
		{
		if ((time()-60*60*72) > $error['time'])
		{
			unset ($errors[$error['videoid']]);
		} elseif(($i<=$page_num*10)AND($i>($page_num*10-10))) {
		$i++;
		
		?>
		<tr>
			<td><INPUT NAME="video_onclick_options[delete][]" TYPE="CHECKBOX" VALUE="<?php echo $error['videoid']; ?>"></td>
			<?php if ('vimeo'==$error['service']) { ?>
			
			<td><a href="http://vimeo.com/<?php echo $error['videoid']; ?>"><?php echo $error['videoid']; ?></a></td>
			
			<?php } else { ?> 
			<td><a href="http://www.youtube.com/watch?v=<?php echo $error['videoid']; ?>"><?php echo $error['videoid']; ?></a></td>
			
			
			<?php } ?>
			<td><?php echo video_onclick_error_code($error['code']); ?></td>
			
			<td><?php echo get_the_title($error['post_id']) ; edit_post_link('Edit', '(',')',$error['post_id']); ?></td>
			
			<td><?php echo date('d/M/Y H:i:s',$error['time']); ?></td>
		</tr>
		<?php
		} else {
			$i++;
		}
		}
	?>
	</table>
	
	<?php echo $pager; 
	
	}
	?>
	<p class="submit">
    <input type="submit" class="button-primary" value="Save Changes" />
    </p>
	</form> 
	<?php
	update_option('video_onclick_errors',$errors);
	
	
}

function video_onclick_error_code($code) {
	switch ($code){
		case 404 :
				return '404 - Video not found.';
				break;
		case 403 : 
				return '403 - Video is private.';
				break;
		default :
				return $code;
		
	}
		
} 

function video_onclick_pager($total,$current=1){
	$return = '';
	for ($i=1; $i<=($total/10); $i++)
	{
		if ($current == $i)
		{
			$return .= $i.' ';
		} else {
			$return .= '<a href="?page=video_onclick&p='.$i.'">'.$i.'</a> ';
		}
	}
	
	return $return;
}

function video_onclick_youtube_info($videoid) {
	$return = false;
	
	$cache = get_option('video_onclick_cache');
	$temp = $cache[$videoid];

	if ((time() - 60*60*24) > $temp['time'])
	{
		// Cache is old or does not exist
		$ch = curl_init();
		$url = 'http://gdata.youtube.com/feeds/api/videos/'. $videoid;	

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
		$respond = curl_exec($ch);
		
		
		
		if (200 == (int)curl_getinfo($ch, CURLINFO_HTTP_CODE))
		{
		
			$temp['width'] = 0;
		
			$sxml = new SimpleXMLElement($respond);

			$media = $sxml->children('http://search.yahoo.com/mrss/');
		

			$temp['description'] = (string) $group->description;
			$group = $media->group;
			$temp['title'] = (string) $group->title;

			foreach( $group->thumbnail as $thumb) {

				if ($temp['width'] < $thumb->attributes()->width) {
				$temp['thumb'] =  (string)$thumb->attributes()->url;
				$temp['width'] = (int)$thumb->attributes()->width;
				$temp['height'] = (int)$thumb->attributes()->height;
				}

			}
			
			
			if ('' == $temp['thumb'])
			{

				$temp['thumb'] = plugins_url().'/video-onclick/play_youtube.jpg';
				$return = $temp;
			} else {
				$temp['time'] = time();
				$cache[$videoid] = $temp;

			
				update_option('video_onclick_cache', $cache);
			
				$return = $temp;
			}
		} else {
			$errors = get_option('video_onclick_errors');
			
			$error['code'] = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$error['videoid'] = $videoid;
			$error['post_id'] = get_the_ID();
			$error['time'] = time();
			$error['service'] = 'youtube';
			
			$errors[$videoid] = $error;
			update_option('video_onclick_errors',$errors);
		
			$temp['thumb'] = plugins_url().'/video-onclick/play_youtube.jpg';
			$temp['description'] = 'This video could not be parsed correctly';
			$temp['title'] = 'Error getting Title';
			$temp['time'] = time();
			
			$cache[$videoid] = $temp;
			update_option('video_onclick_cache', $cache);
			
			$return = $temp;
		}
		
	} else {
		// Cache is OK 
		
		$return = $temp;
	}
	

	return $return;
}

function video_onclick_vimeo_info($videoid) {
	$return = false;
	
	$cache = get_option('video_onclick_cache');
	$temp = $cache[$videoid];

	if ((time() - 60*60*24) > $temp['time'])
	{
		// Cache is old or does not exist
		$ch = curl_init();
		$url = 'http://vimeo.com/api/v2/video/'.$videoid.'.php';	

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
		$respond = curl_exec($ch);
		
		
		
		if (200 == (int)curl_getinfo($ch, CURLINFO_HTTP_CODE))
		{
		
			$temp['width'] = 0;
		
			$result = unserialize($respond);
			
			$temp['title'] = $result[0]['title'];
			$temp['description'] = $result[0]['description'];
			$temp['thumb'] = $result[0]['thumbnail_large'];
			if ('' == $temp['thumb'])
			{

				$temp['thumb'] = plugins_url().'/video-onclick/play_vimeo.jpg';
				$return = $temp;
			} else {
				$temp['time'] = time();
				$cache[$videoid] = $temp;

			
				update_option('video_onclick_cache', $cache);
			
				$return = $temp;
			}
			
			
			
			
			
		
		} else {
			$errors = get_option('video_onclick_errors');
			
			$error['code'] = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$error['videoid'] = $videoid;
			$error['post_id'] = get_the_ID();
			$error['service'] = 'vimeo';
			$error['time'] = time();
			
			
			
			
			$errors[$videoid] = $error;
			update_option('video_onclick_errors',$errors);
		
			$temp['thumb'] = plugins_url().'/video-onclick/play_vimeo.jpg';
			$temp['description'] = 'This video could not be parsed correctly';
			$temp['title'] = 'Error getting Title';
			$temp['time'] = time();
			
			$cache[$videoid] = $temp;
			update_option('video_onclick_cache', $cache);
			
			
			$return = $temp;
		}
		
	} else {
		// Cache is OK 
		
		$return = $temp;
	}
	

	return $return;
}

function register_video_onclick_settings() {
	register_setting('video_onclick_group','video_onclick_options');
}

add_action('admin_menu',"video_onclick_menu");
	
function video_onclick_menu() {
	add_options_page('Video Onclick', 'Video Onclick', 'manage_options', 'video_onclick', 'options_video_onclick');
	add_action( 'admin_init', 'register_video_onclick_settings' );
}
	
add_action("plugins_loaded", "video_onclick_init");

?>