<?php


function crr_sc_list($atts,$content=null) {
    extract(shortcode_atts(array(
        'title' => "",
		'color' => "teal",
	), $atts));
	$dom = new DOMDocument();
	//空pタグWarning非表示
error_reporting(0);
	$dom->loadHTML( mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
error_reporting(-1);
	$table=$dom->getElementsByTagName('table')->item(0);

	
	$trs=$dom->getElementsByTagName('tr');
	
	if($title==''){
		$output="<div class=\"crr-box crr-no-border\">";				
	}else{
		$output="<div class=\"crr-box\" style=\"color:{$color};border-color:{$color}\"><span class=\"box-title\" style=\"background-color:{$color};\">{$title}</span>";		
	}

	$output.='<ul class="list">';
	foreach($trs as $tr){
		
		$td=$tr->getElementsByTagName('td');
		
		$t_label=str_replace(array('[',']'),array('&#91;','&#93;'),$td->item(0)->nodeValue);
		
		$icon=$td->item(0)->nodeValue;
		
		switch($icon){
			case 'check':
				$icon='checkmark-outline';
				break;
			case 'ok':
				$icon='circle-o';
				break;
			case 'x':
				$icon='x-circle';
				break;
			default:
				$icon='circle-right';
				break;
		}

		$t_content	=	$dom->saveXML($td->item(1));
		$output.="<li class=\"ciocn{$icon}\"><span class=\"crr-box-content\">{$t_content}</span></li>";
	}
	$output.='</ul>';

	$output.='</div>';
	
	return do_shortcode($output);
	
}
add_shortcode('crr_ul', 'crr_sc_list');
