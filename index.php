<?php
/*
Plugin Name: JavaScript If Display
Plugin URI: https://github.com/pitolick/JavaScript-If-Display
Description: 正規表現で表示・非表示を切り替えるショートコードを追加します
Version: 1.0.2
Author: ぴいた
License: GPL2
*/

/**
 * 囲い型ショートコードを使ってJavaScriptで表示切り替え
 */
function js_if_display($atts, $content = null) {
	// ショートコードの引数設定
	$atts = shortcode_atts(array(
		'cookie'=>'', // cookieで取得するkey名
		'session_storage'=>'', // sessionStorageで取得するkey名
		'local_storage'=>'', // localStorageで取得するkey名
		'get'=>'', // クエリパラメータで取得するkey名
		'pattern'=>'' // 比較する正規表現リテラル（デリミタを含む）
	), $atts, 'js_if_display');

	// 同一ページ内での発火回数をカウント
	global $js_if_display_count;
	if(!$js_if_display_count) {
		$js_if_display_count = 0;
	}
	$js_if_display_count++;

	// 囲われたコンテンツをラップ
	$result = '<div id="js_if_display-'.$js_if_display_count.'" style="display:none;">' . $content . '</div>';

	// 条件分岐用script生成
	$result .= '<script>var val = {};';

	// cookie取得
	if($atts["cookie"]) {
		$result .= 'var cookies=document.cookie;var cookiesArray=cookies.split("; ");for(var c of cookiesArray){var cArray=c.split("=");if(cArray[0]=="'.$atts["cookie"].'"){val["cookie"] = cArray[1];}}';
	}

	// sessionStorage取得
	if($atts["session_storage"]) {
		$result .= 'val["session_storage"] = sessionStorage.getItem("'.$atts["session_storage"].'");';
	}

	// localStorage取得
	if($atts["local_storage"]) {
		$result .= 'val["local_storage"] = localStorage.getItem("'.$atts["local_storage"].'");';
	}

	// クエリパラメータ取得
	if($atts["get"]) {
		// クエリパラメータ特定Keyで取得構文
		$result .= 'function getParam(b,a){if(!a){a=window.location.href}b=b.replace(/[\[\]]/g,"\\$&");var d=new RegExp("[?&]"+b+"(=([^&#]*)|&|#|$)"),c=d.exec(a);if(!c){return null}if(!c[2]){return""}return decodeURIComponent(c[2].replace(/\+/g," "))};';
		$result .= 'val["get"] = getParam("'.$atts["get"].'");';
	}

	// 正規表現に1つでも一致したら表示
	$result .= 'var pattern = '.$atts["pattern"].';';
	$result .= 'var element = document.getElementById("js_if_display-'.$js_if_display_count.'");';

	$result .= 'for(var key in val) {
    if(val.hasOwnProperty(key)) {
      var value = val[key];
			if(value.match(pattern)) {
				element.style.display = "block";
			}
    }
  }';
	$result .= '</script>';

	return $result;
}
add_shortcode('js_if_display', 'js_if_display');