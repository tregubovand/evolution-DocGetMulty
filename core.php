<?php
	$separator = $separator ? $separator : '||';
	$subSeparator = $subSeparator ? $subSeparator : '::';
	
	$rows = explode($separator, $input);	
	$row_index = 0;
	if(!count($rows)) return;
	foreach($rows as $row){
		if(isset($total) && !$total--){
			break;
		}
		$cols = explode($subSeparator, $row);
		$i = 0;
		$out = $tpl;
		foreach($cols as $col){
			if(isset($image) && $i == $image && isset($options)){
				$col = $modx->runSnippet("phpthumb", ['input'=>$col, 'options'=>$options]);
			}
			
			if($col){
				$out = str_replace("[+col$i+]", $col, $out);
				$out = str_replace("[col$i]", $col, $out);
				$i++;
			}else{
				$out = str_replace("[+col$i+]", '', $out);
				$out = str_replace("[col$i]", '', $out);
			}
		}
		
		$out = str_replace("[+i+]", $row_index, $out);
		
		if(isset($firstPlaceholder) && $row_index == 0){
			$out = str_replace("[+first+]", $firstPlaceholder, $out);
		}
		$row_index++;
		
		$out = preg_replace("/\[\+.+\+\]/", '', $out);
		if($i){
			echo $out;
		}
	}
