<?php
/*
Plugin Name: RAX - Google Language Translator
Plugin URI: http://www.phpfreelancedevelopers.com/wordpress-rax-google-language-translator-plugin/
Description: RAX - Google Language Translator provide the easiest way to give a way to your visitor for change of language option. Google provides a language translator and based on that this plugin will call Google Translator tool to convert page into language selected by visitor.
Version: 1.0
Author: Rakshit Patel
Author URI: http://www.phpfreelancedevelopers.com
License: GPL2
*/

/*  Copyright 2010  Rakshit Patel  (email : raxit4u2@gmail.com)

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

add_option("rax_show_translator","0");
add_option("rax_translate_layout","");

add_action('admin_menu', 'rax_google_language_translator_menu_options');

add_action('wp_footer', 'rax_google_language_translator_show');

function rax_google_language_translator_menu_options(){
	  add_options_page('RAX - Google Language Translator', ' RAX - Google Language Translator', 'manage_options', 'rax-google-language-translator-menu-options', 'rax_google_language_translator_options');
}

function rax_google_language_translator_options(){
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	?>
  	<div style="width:95%; font-size:11px; padding:3px 3px 3px 15px;">
	  <p style="font-size:20px; background-color:#4086C7; color:#FFF; width:94%; padding:2px;">Set Options for RAX - Google Language Translator</p>
      <p>
        <form method="post" action="options.php">
            <?php wp_nonce_field('update-options');?>
            <table width="100%" border="0" cellspacing="8" cellpadding="0" class="form-table">
              <tr>
                <td width="30%" align="left" valign="top">Want to Activate Google Translator Tool ? : </td>
                <td align="left" valign="top"><input type="checkbox" name="rax_show_translator" id="rax_show_translator" value="1" <?php if(get_option('rax_show_translator')==1) echo "checked='checked'"; ?> /></td>
              </tr>
              <tr>
                <td align="left" valign="top">Select Layout</td>
                <td align="left" valign="top">
                	<select name="rax_translate_layout" id="rax_translate_layout">
                        <option value="" <?php if(get_option('rax_translate_layout') == '') echo 'selected="selected"';?>>Vertical</option>
                        <option value="HORIZONTAL" <?php if(get_option('rax_translate_layout') == 'HORIZONTAL') echo 'selected="selected"';?>>Horizontal</option>
                        <option value="SIMPLE" <?php if(get_option('rax_translate_layout') == 'SIMPLE') echo 'selected="selected"';?>>Dropdown only</option>
                    </select>
                </td>
              </tr>
              <tr>
                <td align="left" valign="top" colspan="2"><input type="submit" value="<?php _e('Update Option')?>" /></td>
              </tr>
            </table>
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="rax_show_translator,rax_translate_layout" />
        </form>
	  </p>
	<?php
}

function rax_google_language_translator_show() {
	
	$rax_show_translator = get_option('rax_show_translator');
	$rax_translate_layout = get_option('rax_translate_layout');
	
	$wpfooter = '';
	if($rax_show_translator == 1) {
		
		$wpfooter = "<div style='float:right;padding:10px;'>
					<div id='google_translate_element'></div><script>
					function googleTranslateElementInit() {
					  new google.translate.TranslateElement({
						pageLanguage: 'en'";
						
		if($rax_translate_layout)
			$wpfooter .= ",layout: google.translate.TranslateElement.InlineLayout.".$rax_translate_layout;
						
		$wpfooter .= " }, 'google_translate_element');
					}
					</script>
					<script src='//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit'></script>
					</div>";
	}
	echo $wpfooter;
}
?>