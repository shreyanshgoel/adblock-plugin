<?php
/**
 * 
 *Plugin Name: MonitorAdblock
 *Description: Whitelist your AdBlock Traffic. Find out how many of your visitors are blocking your Ads. See exactly how visitors are accessing your website broken down by device type along with detailed platform information and which country the visitor is located in.
 *Version: 1.0
 *Author: vNative
 *Author URI: http://vnative.com
*/

$upload_dir = wp_upload_dir();

$url = plugin_dir_url( $file );

$m = get_option('adblock_message');

    if(empty($m)){

      $m = 'Please Disable Your adblocker to view this site.';
    }


function myplugin_footer_function() {
    
    global $url;

    $m = get_option('adblock_message');

    if(empty($m)){

      $m = 'Please Disable Your adblocker to view this site.';
    }

    $ext = get_option('adblock_image_ext');

    echo "
    <!--Monitor Adblock Plugin-->
    <style>
#rba2{position:fixed !important;position:absolute;top:0px;top:expression((t=document.documentElement.scrollTop?document.documentElement.scrollTop:document.body.scrollTop)+'px');left:0px;width:100%;height:100%;background-color:#fff;opacity:.95;filter:alpha(opacity=95);display:block;padding:13% 0}#rba2 {text-align:center;margin:0 auto;display:block;filter:none;font:bold 14px Verdana,Arial,sans-serif;text-decoration:none}#rba2 ~ {display:none}
</style>

<span id='blue_screen' style='display:none'><font id='rba2'><b>Please disable adblock to visit our website, this help us to pay hosting bill.</b><br><br>";

      if(!empty($ext)){

          echo "<img src='" . $upload_dir['baseurl'] . "wp-content/uploads/adblock_image." . $ext . "'>";
        }else{

          echo "<img src='" . $url . "MonitorAdblock/adblock.png'>";
        }

echo "</font></span>

</div>


<script> 
  
  window.onload = function() { 
  
    // Delay to allow the async Google Ads to load
    setTimeout(function() { 
      
      // Get the first AdSense ad unit on the page
      var ad = document.querySelector('ins.adsbygoogle');
      
      // If the ads are not loaded, track the event
      if (ad && ad.innerHTML.replace(/\s/g, '').length == 0) {
 
        if (typeof ga !== 'undefined') {
 
            // Log an event in Universal Analytics
            // but without affecting overall bounce rate
            ga('send', 'event', 'Adblock', 'Yes', {'nonInteraction': 1}); 
 
        } else if (typeof _gaq !== 'undefined') {
 
            // Log a non-interactive event in old Google Analytics
            _gaq.push(['_trackEvent', 'Adblock', 'Yes', undefined, undefined, true]);
 
        }
      }
    }, 2000); // Run ad block detection 2 seconds after page load
  }; 

 /*
 * BlockAdBlock 3.2.1
 * Copyright (c) 2015 Valentin Allaire <valentin.allaire@sitexw.fr>
 * Released under the MIT license
 * https://github.com/sitexw/BlockAdBlock
 */

(function(window) {
  var BlockAdBlock = function(options) {
    this._options = {
      checkOnLoad:    false,
      resetOnEnd:     false,
      loopCheckTime:    50,
      loopMaxNumber:    5,
      baitClass:      'pub_300x250 pub_300x250m pub_728x90 text-ad textAd text_ad text_ads text-ads text-ad-links',
      baitStyle:      'width: 1px !important; height: 1px !important; position: absolute !important; left: -10000px !important; top: -1000px !important;',
      debug:        false
    };
    this._var = {
      version:      '3.2.1',
      bait:       null,
      checking:     false,
      loop:       null,
      loopNumber:     0,
      event:        { detected: [], notDetected: [] }
    };
    if(options !== undefined) {
      this.setOption(options);
    }
    var self = this;
    var eventCallback = function() {
      setTimeout(function() {
        if(self._options.checkOnLoad === true) {
          if(self._options.debug === true) {
            self._log('onload->eventCallback', 'A check loading is launched');
          }
          if(self._var.bait === null) {
            self._creatBait();
          }
          setTimeout(function() {
            self.check();
          }, 1);
        }
      }, 1);
    };
    if(window.addEventListener !== undefined) {
      window.addEventListener('load', eventCallback, false);
    } else {
      window.attachEvent('onload', eventCallback);
    }
  };
  BlockAdBlock.prototype._options = null;
  BlockAdBlock.prototype._var = null;
  BlockAdBlock.prototype._bait = null;
  
  BlockAdBlock.prototype._log = function(method, message) {
    console.log('[BlockAdBlock]['+method+'] '+message);
  };
  
  BlockAdBlock.prototype.setOption = function(options, value) {
    if(value !== undefined) {
      var key = options;
      options = {};
      options[key] = value;
    }
    for(var option in options) {
      this._options[option] = options[option];
      if(this._options.debug === true) {
        this._log('setOption', 'The option');
      }
    }
    return this;
  };
  
  BlockAdBlock.prototype._creatBait = function() {
    var bait = document.createElement('div');
      bait.setAttribute('class', this._options.baitClass);
      bait.setAttribute('style', this._options.baitStyle);
    this._var.bait = window.document.body.appendChild(bait);
    
    this._var.bait.offsetParent;
    this._var.bait.offsetHeight;
    this._var.bait.offsetLeft;
    this._var.bait.offsetTop;
    this._var.bait.offsetWidth;
    this._var.bait.clientHeight;
    this._var.bait.clientWidth;
    
    if(this._options.debug === true) {
      this._log('_creatBait', 'Bait has been created');
    }
  };
  BlockAdBlock.prototype._destroyBait = function() {
    window.document.body.removeChild(this._var.bait);
    this._var.bait = null;
    
    if(this._options.debug === true) {
      this._log('_destroyBait', 'Bait has been removed');
    }
  };
  
  BlockAdBlock.prototype.check = function(loop) {
    if(loop === undefined) {
      loop = true;
    }
    
    if(this._options.debug === true) {
      this._log('check', 'An audit was requested '+(loop===true?'with a':'without')+' loop');
    }
    
    if(this._var.checking === true) {
      if(this._options.debug === true) {
        this._log('check', 'A check was canceled because there is already an ongoing');
      }
      return false;
    }
    this._var.checking = true;
    
    if(this._var.bait === null) {
      this._creatBait();
    }
    
    var self = this;
    this._var.loopNumber = 0;
    if(loop === true) {
      this._var.loop = setInterval(function() {
        self._checkBait(loop);
      }, this._options.loopCheckTime);
    }
    setTimeout(function() {
      self._checkBait(loop);
    }, 1);
    if(this._options.debug === true) {
      this._log('check', 'A check is in progress ...');
    }
    
    return true;
  };
  BlockAdBlock.prototype._checkBait = function(loop) {
    var detected = false;
    
    if(this._var.bait === null) {
      this._creatBait();
    }
    
    if(window.document.body.getAttribute('abp') !== null
    || this._var.bait.offsetParent === null
    || this._var.bait.offsetHeight == 0
    || this._var.bait.offsetLeft == 0
    || this._var.bait.offsetTop == 0
    || this._var.bait.offsetWidth == 0
    || this._var.bait.clientHeight == 0
    || this._var.bait.clientWidth == 0) {
      detected = true;
    }
    if(window.getComputedStyle !== undefined) {
      var baitTemp = window.getComputedStyle(this._var.bait, null);
      if(baitTemp && (baitTemp.getPropertyValue('display') == 'none' || baitTemp.getPropertyValue('visibility') == 'hidden')) {
        detected = true;
      }
    }
    
    if(this._options.debug === true) {
      this._log('_checkBait', 'A check ('+(this._var.loopNumber+1)+'/'+this._options.loopMaxNumber+' ~'+(1+this._var.loopNumber*this._options.loopCheckTime)+'ms) was conducted and detection is '+(detected===true?'positive':'negative'));
    }
    
    if(loop === true) {
      this._var.loopNumber++;
      if(this._var.loopNumber >= this._options.loopMaxNumber) {
        this._stopLoop();
      }
    }
    
    if(detected === true) {
      this._stopLoop();
      this._destroyBait();
      this.emitEvent(true);
      if(loop === true) {
        this._var.checking = false;
      }
    } else if(this._var.loop === null || loop === false) {
      this._destroyBait();
      this.emitEvent(false);
      if(loop === true) {
        this._var.checking = false;
      }
    }
  };
  BlockAdBlock.prototype._stopLoop = function(detected) {
    clearInterval(this._var.loop);
    this._var.loop = null;
    this._var.loopNumber = 0;
    
    if(this._options.debug === true) {
      this._log('_stopLoop', 'A loop has been stopped');
    }
  };
  
  BlockAdBlock.prototype.emitEvent = function(detected) {
    if(this._options.debug === true) {
      this._log('emitEvent', 'An event with a '+(detected===true?'positive':'negative')+' detection was called');
    }
    
    var fns = this._var.event[(detected===true?'detected':'notDetected')];
    for(var i in fns) {
      if(this._options.debug === true) {
        this._log('emitEvent', 'Call function '+(parseInt(i)+1)+'/'+fns.length);
      }
      if(fns.hasOwnProperty(i)) {
        fns[i]();
      }
    }
    if(this._options.resetOnEnd === true) {
      this.clearEvent();
    }
    return this;
  };
  BlockAdBlock.prototype.clearEvent = function() {
    this._var.event.detected = [];
    this._var.event.notDetected = [];
    
    if(this._options.debug === true) {
      this._log('clearEvent', 'The event list has been cleared');
    }
  };
  
  BlockAdBlock.prototype.on = function(detected, fn) {
    this._var.event[(detected===true?'detected':'notDetected')].push(fn);
    if(this._options.debug === true) {
      this._log('on', 'A type of event was added');
    }
    
    return this;
  };
  BlockAdBlock.prototype.onDetected = function(fn) {
    return this.on(true, fn);
  };
  BlockAdBlock.prototype.onNotDetected = function(fn) {
    return this.on(false, fn);
  };
  
  window.BlockAdBlock = BlockAdBlock;
  
  if(window.blockAdBlock === undefined) {
    window.blockAdBlock = new BlockAdBlock({
      checkOnLoad: true,
      resetOnEnd: true
    });
  }
})(window);

var b = window.blockAdBlock;
b.onDetected(function () {
  
  document.getElementById('blue_screen').style.display = 'block';

});
b.onNotDetected(function () {

});
  
</script>


<!--Monitor Adblock Plugin-->";

}
add_action( 'wp_footer', 'myplugin_footer_function' );
 
add_option('adblock_message');
add_option('adblock_image_ext');

if(isset($_POST['save_image'])){

  update_option('adblock_message', $_POST['adblock_message']);

  if(!empty($_FILES['adblock_image']['name'])){
  
    $check = getimagesize($_FILES["adblock_image"]["tmp_name"]);

    if($check !== false) {
        
        $imageFileType = pathinfo($_FILES['adblock_image']['name'],PATHINFO_EXTENSION);

        move_uploaded_file($_FILES["adblock_image"]["tmp_name"], ABSPATH . 'wp-content/uploads/adblock_image.' . $imageFileType);

        update_option('adblock_image_ext', $imageFileType);
    }
  }

  header("Location: options-general.php?page=monitoradblock&updated=true");


  
}

function ma_custom_admin_menu() {
    add_options_page(
        'Monitor Adblock',
        'Monitor Adblock',
        'manage_options',
        'monitoradblock',
        'ma_options_page'
    );
}

function ma_options_page() {

  global $m;
  
  include 'settings.php';

}
add_action( 'admin_menu', 'ma_custom_admin_menu' );

function mn_plugin_row_meta( $links, $file ) {

    if (strpos( $file,'monitoradblock.php') !== false ) {
        $new_links = array('<a href="mailto:support@vnative.com">Support</a>');
        $links = array_merge( $links, $new_links );
    }
    
    return $links;
}

add_filter('plugin_row_meta', 'mn_plugin_row_meta', 10, 2 );

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_action_links' );

function add_action_links ( $links ) {
 $mylinks = array(
 '<a href="options-general.php?page=monitoradblock">Settings</a>',
 );
return array_merge( $links, $mylinks );
}