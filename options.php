<?php 

if (is_user_logged_in() && is_admin()) {
	
	load_plugin_textdomain($this->stringTextdomain, false, dirname(plugin_basename(__FILE__)) . '/translation');
	
	$adminSettings = $this->defaultOptions;

	if (isset($_POST['update-urlbox_plugin_options'])) {//save option changes
		foreach ($adminSettings as $key => $val){
			if (isset($_POST[$key])) {
				$adminSettings[$key] = trim($_POST[$key]);
			}
		}
	
		update_option('urlbox_plugin_options', $adminSettings);
	}
	
	$adminOptions = $this->getAdminOptions();
	
	// $this->registerRewriteRules();
	// $this->flushRewriteRules();
	
	// $possibleProductTypes = $this->getTypesData(null);
	
	unset($_SESSION['_tac']);

?>
<style>
.form-table td {
	vertical-align: top;
}
ul.sploplist {
	list-style: inherit !important;
}
</style>
<div class="wrap">
  <?php 
  screen_icon(); 
  ?>
  <h2>Urlbox Plugin Options &raquo; Settings</h2>
  <div id="sprdplg-message" class="updated fade" style="display:none"></div>
  <div class="metabox-holder">
    <div class="meta-box-sortables ui-sortable">
      <div class="postbox">
        <div class="handlediv" title="Click to toggle"><br />
        </div>
        <h3 class="hndle">Urlbox Plugin
          <?php _e('Settings','urlboxplugin'); ?>
        </h3>
        <div class="inside">
          <p>
            <?php _e('These settings will be used as default and can be overwritten by the extended shortcode.','urlboxplugin'); ?>
          </p>
          <form action="options-general.php?page=urlbox_plugin_options&saved" method="post" id="urlbox_plugin_options_form" name="urlbox_plugin_options_form">
            <?php wp_nonce_field('urlbox_plugin_options'); ?>
            <table border="0" cellpadding="3" cellspacing="0" class="form-table">
              <tr>
                <td valign="top"><?php _e('Urlbox API Key:','urlboxplugin'); ?></td>
                <td><input type="text" name="api" value="<?php echo $adminOptions['api']; ?>" class="required" /></td>
              </tr>
              <tr>
                <td valign="top"><?php _e('Urlbox API Secret:','urlboxplugin'); ?></td>
                <td><input type="text" name="secret" value="<?php echo $adminOptions['secret']; ?>" class="required" /></td>
              </tr>
              
              <tr>
                <td valign="top"><?php _e('Thumb Width:','urlboxplugin'); ?></td>
                <td><input type="text" name="thumb_width" value="<?php echo $adminOptions['thumb_width']; ?>" class="only-digit" /></td>
              </tr>
              <tr>
                <td valign="top"><?php _e('Viewport Width:','urlboxplugin'); ?></td>
                <td><input type="text" name="width" value="<?php echo (empty($adminOptions['viewport_width'])?1280:$adminOptions['viewport_width']); ?>" class="only-digit" /></td>
              </tr>
              <tr>
                <td valign="top"><?php _e('Viewport Height:','urlboxplugin'); ?></td>
                <td><input type="text" name="height" value="<?php echo (empty($adminOptions['viewport_height'])?1024:$adminOptions['viewport_height']); ?>" class="only-digit" /></td>
              </tr>
              <tr>
                <td valign="top"><?php _e('Delay:','urlboxplugin'); ?></td>
                <td><input type="text" name="delay" value="<?php echo $adminOptions['delay']; ?>" class="only-digit " /></td>
              </tr>
              <tr>
                <td valign="top"><?php _e('User Agent:','urlboxplugin'); ?></td>
                <td><input type="text" name="user_agent" value="<?php echo $adminOptions['user_agent']; ?>" class=" " /></td>
              </tr>
              <tr>
                <td valign="top"><?php _e('JPEG Quality:','urlboxplugin'); ?></td>
                <td><input type="text" name="quality" value="<?php echo $adminOptions['quality']; ?>" class="only-digit" /></td>
              </tr>
              <tr>
                <td valign="top"><?php _e('Disable JS:','urlboxplugin'); ?></td>
                <td><input type="radio" name="disable_js" value="0"<?php echo ($adminOptions['disable_js']==0?" checked":"") ?> />
                  <?php _e('Off','urlboxplugin'); ?>
                  <br />
                  <input type="radio" name="disable_js" value="1"<?php echo ($adminOptions['disable_js']==1?" checked":"") ?> />
                  <?php _e('On','urlboxplugin'); ?></td>
              </tr>
              <tr>
                <td valign="top"><?php _e('Full Height Screenshot:','urlboxplugin'); ?></td>
                <td><input type="radio" name="full_page" value="0"<?php echo ($adminOptions['full_page']==0?" checked":"") ?> />
                  <?php _e('Off','urlboxplugin'); ?>
                  <br />
                  <input type="radio" name="full_page" value="1"<?php echo ($adminOptions['full_page']==1?" checked":"") ?> />
                  <?php _e('On','urlboxplugin'); ?></td>
              </tr>
              <tr>
                <td valign="top"><?php _e('Retina Resolution?:','urlboxplugin'); ?></td>
                <td><input type="radio" name="retina" value="0"<?php echo ($adminOptions['retina']==0?" checked":"") ?> />
                  <?php _e('Disabled','urlboxplugin'); ?>
                  <br />
                  <input type="radio" name="retina" value="1"<?php echo ($adminOptions['retina']==1?" checked":"") ?> />
                  <?php _e('Enabled','urlboxplugin'); ?></td>
              </tr>
              <tr>
                <td valign="top"><?php _e('Force?:','urlboxplugin'); ?></td>
                <td><input type="radio" name="force" value="0"<?php echo ($adminOptions['force']==0?" checked":"") ?> />
                  <?php _e('Disabled','urlboxplugin'); ?>
                  <br />
                  <input type="radio" name="force" value="1"<?php echo ($adminOptions['force']==1?" checked":"") ?> />
                  <?php _e('Enabled','urlboxplugin'); ?></td>
              </tr>
              <tr>
                <td valign="top"><?php _e('TTL (seconds):','urlboxplugin'); ?></td>
                <td><input type="text" name="ttl" value="<?php echo $adminOptions['ttl']; ?>" class="only-digit" /></td>
              </tr>
              <tr>
                <td valign="top"><?php _e('Default Format:','urlboxplugin'); ?></td>
                <td><input type="radio" name="format" value="1"<?php echo ($adminOptions['format']==0?" checked":"") ?> />
                  <?php _e('PNG','urlboxplugin'); ?>
                  <br />
                  <input type="radio" name="format" value="0"<?php echo ($adminOptions['format']==1?" checked":"") ?> />
                  <?php _e('JPG','urlboxplugin'); ?></td>
              </tr>
              <tr>
                <td valign="top"><?php _e('Debug?:','urlboxplugin'); ?></td>
                <td><input type="radio" name="debug" value="0"<?php echo ($adminOptions['debug']==0?" checked":"") ?> />
                  <?php _e('Disabled','urlboxplugin'); ?>
                  <br />
                  <input type="radio" name="debug" value="1"<?php echo ($adminOptions['debug']==1?" checked":"") ?> />
                  <?php _e('Enabled','urlboxplugin'); ?></td>
              </tr>
            </table>
            <input type="submit" name="update-urlbox_plugin_options" id="update-urlbox_plugin_options" class="button-primary" value="<?php _e('Update settings','urlboxplugin'); ?>" />
            <input type="button" onclick="javascript:rebuild();" class="button-primary" value="<?php _e('Rebuild cache','urlboxplugin'); ?>" />
          </form>
        </div>
      </div>
      <div class="postbox">
        <div class="handlediv" title="Click to toggle"><br />
        </div>
        <h3 class="hndle">Shortcode Samples</h3>
        <div class="inside">
          <h4>
            <?php _e('Minimum required shortcode','urlboxplugin'); ?>
          </h4>
          <p>[urlbox url="someurl"]</p>
          <h4>
            <?php _e('Sample shortcode with custom thumb_width','urlboxplugin'); ?>
          </h4>
          <p>[urlbox thumb_width=&quot;600&quot;]</p>
          <p>&nbsp;</p>
          <a href='https://urlbox.io/docs'>See the urlbox.io docs for more info on each parameter</a>
          <h4>
            <?php _e('Use one of the following shortcode extensions to overwrite or extend each shortcode.','urlboxplugin'); ?>
          </h4>
          <p>
            <?php
  
  $_plgop = '';
  foreach ($adminOptions as $k => $v) {	
		$_plgop .= $k.'="'.'"<br>';
  }
  
  echo trim($_plgop);
  
  ?>
          </p>
          <p>&nbsp;</p>
        </div>
      </div>
    </div>
  </div>
</div>
<script
<?php 
if (isset($_GET['saved'])) {
	/*echo '<script language="javascript">rebuild();</script>';*/
	echo '<script language="javascript">setMessage("<p>'.__('Successfully saved settings. Please click rebuild cache if necessary.','urlboxplugin').'</p>");</script>';
}


} ?>
