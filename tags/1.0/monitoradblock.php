<?php
/**
 * 
 *Plugin Name: MonitorAdblock
 *Description: Whitelist your AdBlock Traffic. Find out how many of your visitors are blocking your Ads. See exactly how visitors are accessing your website broken down by device type along with detailed platform information and which country the visitor is located in.
 *Version: 1.0
 *Author: vNative
 *Author URI: http://vnative.com
*/


$m = get_option('adblock_message');

if(empty($m)){

  $m = 'Please Disable Your adblocker to view this site.';

}

$image = get_option('adblock_image_url');


function easy_ma_footer_function() {

    $m = get_option('adblock_message');

    if(empty($m)){

      $m = 'Please Disable Your adblocker to view this site.';
    }

    $url = get_option('adblock_image_url');

    if(empty($url)){

      $url = plugins_url( 'adblock.png', __FILE__ );

    }

    echo "
    <!--Monitor Adblock Plugin-->
    <style>
#rba2{position:fixed !important;position:absolute;top:0px;top:expression((t=document.documentElement.scrollTop?document.documentElement.scrollTop:document.body.scrollTop)+'px');left:0px;width:100%;height:100%;background-color:#fff;opacity:.95;filter:alpha(opacity=95);display:block;padding:13% 0}#rba2 {text-align:center;margin:0 auto;display:block;filter:none;font:bold 14px Verdana,Arial,sans-serif;text-decoration:none}#rba2 ~ {display:none}
</style>

<span id='blue_screen' style='display:none'><font id='rba2' style='z-index:2000'><b>Please disable adblock to visit our website, this help us to pay hosting bill.</b><br><br>";

          echo "<img src='" . $url . "'>";


echo "</font></span>

</div>


<script> 
  
  window.onload=function(){setTimeout(function(){var e=document.querySelector('ins.adsbygoogle');e&&0==e.innerHTML.replace(/\s/g,'').length&&('undefined'!==typeof ga?ga('send','event','Adblock','Yes',{nonInteraction:1}):'undefined'!==typeof _gaq&&_gaq.push(['_trackEvent','Adblock','Yes',void 0,void 0,!0]))},2E3)};
(function(e){var d=function(a){this._options={checkOnLoad:!1,resetOnEnd:!1,loopCheckTime:50,loopMaxNumber:5,baitClass:'pub_300x250 pub_300x250m pub_728x90 text-ad textAd text_ad text_ads text-ads text-ad-links',baitStyle:'width: 1px !important; height: 1px !important; position: absolute !important; left: -10000px !important; top: -1000px !important;',debug:!1};this._var={version:'3.2.1',bait:null,checking:!1,loop:null,loopNumber:0,event:{detected:[],notDetected:[]}};void 0!==a&&this.setOption(a);
var c=this;a=function(){setTimeout(function(){!0===c._options.checkOnLoad&&(!0===c._options.debug&&c._log('onload->eventCallback','A check loading is launched'),null===c._var.bait&&c._creatBait(),setTimeout(function(){c.check()},1))},1)};void 0!==e.addEventListener?e.addEventListener('load',a,!1):e.attachEvent('onload',a)};d.prototype._options=null;d.prototype._var=null;d.prototype._bait=null;d.prototype._log=function(a,c){console.log('[BlockAdBlock]['+a+'] '+c)};d.prototype.setOption=function(a,
c){if(void 0!==c){var d=a;a={};a[d]=c}for(var e in a)this._options[e]=a[e],!0===this._options.debug&&this._log('setOption','The option');return this};d.prototype._creatBait=function(){var a=document.createElement('div');a.setAttribute('class',this._options.baitClass);a.setAttribute('style',this._options.baitStyle);this._var.bait=e.document.body.appendChild(a);this._var.bait.offsetParent;this._var.bait.offsetHeight;this._var.bait.offsetLeft;this._var.bait.offsetTop;this._var.bait.offsetWidth;this._var.bait.clientHeight;
this._var.bait.clientWidth;!0===this._options.debug&&this._log('_creatBait','Bait has been created')};d.prototype._destroyBait=function(){e.document.body.removeChild(this._var.bait);this._var.bait=null;!0===this._options.debug&&this._log('_destroyBait','Bait has been removed')};d.prototype.check=function(a){void 0===a&&(a=!0);!0===this._options.debug&&this._log('check','An audit was requested '+(!0===a?'with a':'without')+' loop');if(!0===this._var.checking)return!0===this._options.debug&&this._log('check',
'A check was canceled because there is already an ongoing'),!1;this._var.checking=!0;null===this._var.bait&&this._creatBait();var c=this;this._var.loopNumber=0;!0===a&&(this._var.loop=setInterval(function(){c._checkBait(a)},this._options.loopCheckTime));setTimeout(function(){c._checkBait(a)},1);!0===this._options.debug&&this._log('check','A check is in progress ...');return!0};d.prototype._checkBait=function(a){var c=!1;null===this._var.bait&&this._creatBait();if(null!==e.document.body.getAttribute('abp')||
null===this._var.bait.offsetParent||0==this._var.bait.offsetHeight||0==this._var.bait.offsetLeft||0==this._var.bait.offsetTop||0==this._var.bait.offsetWidth||0==this._var.bait.clientHeight||0==this._var.bait.clientWidth)c=!0;if(void 0!==e.getComputedStyle){var d=e.getComputedStyle(this._var.bait,null);!d||'none'!=d.getPropertyValue('display')&&'hidden'!=d.getPropertyValue('visibility')||(c=!0)}!0===this._options.debug&&this._log('_checkBait','A check ('+(this._var.loopNumber+1)+'/'+this._options.loopMaxNumber+
' ~'+(1+this._var.loopNumber*this._options.loopCheckTime)+'ms) was conducted and detection is '+(!0===c?'positive':'negative'));!0===a&&(this._var.loopNumber++,this._var.loopNumber>=this._options.loopMaxNumber&&this._stopLoop());if(!0===c)this._stopLoop(),this._destroyBait(),this.emitEvent(!0),!0===a&&(this._var.checking=!1);else if(null===this._var.loop||!1===a)this._destroyBait(),this.emitEvent(!1),!0===a&&(this._var.checking=!1)};d.prototype._stopLoop=function(a){clearInterval(this._var.loop);
this._var.loop=null;this._var.loopNumber=0;!0===this._options.debug&&this._log('_stopLoop','A loop has been stopped')};d.prototype.emitEvent=function(a){!0===this._options.debug&&this._log('emitEvent','An event with a '+(!0===a?'positive':'negative')+' detection was called');a=this._var.event[!0===a?'detected':'notDetected'];for(var c in a)if(!0===this._options.debug&&this._log('emitEvent','Call function '+(parseInt(c)+1)+'/'+a.length),a.hasOwnProperty(c))a[c]();!0===this._options.resetOnEnd&&this.clearEvent();
return this};d.prototype.clearEvent=function(){this._var.event.detected=[];this._var.event.notDetected=[];!0===this._options.debug&&this._log('clearEvent','The event list has been cleared')};d.prototype.on=function(a,c){this._var.event[!0===a?'detected':'notDetected'].push(c);!0===this._options.debug&&this._log('on','A type of event was added');return this};d.prototype.onDetected=function(a){return this.on(!0,a)};d.prototype.onNotDetected=function(a){return this.on(!1,a)};e.BlockAdBlock=d;void 0===
e.blockAdBlock&&(e.blockAdBlock=new d({checkOnLoad:!0,resetOnEnd:!0}))})(window);var b=window.blockAdBlock;b.onDetected(function(){document.getElementById('blue_screen').style.display='block'});b.onNotDetected(function(){});
  
  
</script>


<!--Monitor Adblock Plugin-->";

}
add_action( 'wp_footer', 'easy_ma_footer_function' );

add_option('adblock_message');
add_option('adblock_image_url');

add_action('admin_init', 'easy_ma_register_my_setting');

function easy_ma_register_my_setting(){

  register_setting('adblock_options', 'adblock_message');
  register_setting('adblock_options', 'adblock_image_url');
}

function easy_ma_custom_admin_menu() {
    add_options_page(
        'Monitor Adblock',
        'Monitor Adblock',
        'manage_options',
        'monitoradblock',
        'easy_ma_options_page'
    );
}

function easy_ma_options_page() {

  global $m, $image;
  
  include 'settings.php';

}
add_action( 'admin_menu', 'easy_ma_custom_admin_menu' );

function easy_ma_plugin_row_meta( $links, $file ) {

    if (strpos( $file,'monitoradblock.php') !== false ) {
        $new_links = array('<a href="mailto:support@vnative.com">Support</a>');
        $links = array_merge( $links, $new_links );
    }
    
    return $links;
}

add_filter('plugin_row_meta', 'easy_ma_plugin_row_meta', 10, 2 );

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'easy_ma_add_action_links' );

function easy_ma_add_action_links ( $links ) {
 $mylinks = array(
 '<a href="options-general.php?page=monitoradblock">Settings</a>',
 );
return array_merge( $links, $mylinks );
}