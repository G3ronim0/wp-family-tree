<?php
/*
Copyright (c) 2010,2011 Arvind Shah
WP Family Tree is released under the GNU General Public
License (GPL) http://www.gnu.org/licenses/gpl.txt
*/

function family_tree_options_page() {
	if (function_exists('add_options_page')) {
		add_options_page('WP Family Tree', 'WP Family Tree', 10, 'wp-family-tree', 'family_tree_options_subpanel');
	}
}
function family_tree_options_subpanel() {
	global $wp_version;

	if (isset($_POST['update_options'])) {

		if ( function_exists('check_admin_referer') ) {
			check_admin_referer('family-tree-action_options');
		}

		if ($_POST['family_tree_category_key'] != "")  {
			update_option('family_tree_category_key', stripslashes(strip_tags($_POST['family_tree_category_key'])));
		}
		if ($_POST['family_tree_link'] != "")  {
			update_option('family_tree_link', stripslashes(strip_tags($_POST['family_tree_link'])));
		}
		update_option('show_biodata_on_posts_page', 		($_POST['show_biodata_on_posts_page']=='Y')?'true':'false');

		update_option('family_tree_toolbar_blogpage', stripslashes(strip_tags($_POST['family_tree_toolbar_blogpage'])));
		update_option('family_tree_toolbar_treenav', stripslashes(strip_tags($_POST['family_tree_toolbar_treenav'])));

		update_option('showcreditlink', 			($_POST['showcreditlink']=='Y')?'true':'false');
		update_option('bOneNamePerLine', 		($_POST['bOneNamePerLine']=='Y')?'true':'false');
		update_option('bOnlyFirstName', 			($_POST['bOnlyFirstName']=='Y')?'true':'false');
		update_option('bBirthAndDeathDates', 	($_POST['bBirthAndDeathDates']=='Y')?'true':'false');
		update_option('bConcealLivingDates', 	($_POST['bConcealLivingDates']=='Y')?'true':'false');
		update_option('bShowSpouse', 				($_POST['bShowSpouse']=='Y')?'true':'false');
		update_option('bShowOneSpouse', 			($_POST['bShowOneSpouse']=='Y')?'true':'false');
		update_option('bVerticalSpouses', 		($_POST['bVerticalSpouses']=='Y')?'true':'false');
		update_option('bMaidenName', 				($_POST['bMaidenName']=='Y')?'true':'false');
		update_option('bShowGender', 				($_POST['bShowGender']=='Y')?'true':'false');
		update_option('bDiagonalConnections', 	($_POST['bDiagonalConnections']=='Y')?'true':'false');
		update_option('bRefocusOnClick', 		($_POST['bRefocusOnClick']=='Y')?'true':'false');
		update_option('bShowToolbar', 			($_POST['bShowToolbar']=='Y')?'true':'false');

		if ($_POST['canvasbgcol'] != "")  {
			update_option('canvasbgcol', stripslashes(strip_tags($_POST['canvasbgcol'])));
		}
		if ($_POST['nodeoutlinecol'] != "")  {
			update_option('nodeoutlinecol', stripslashes(strip_tags($_POST['nodeoutlinecol'])));
		}
		if ($_POST['nodefillcol'] != "")  {
			update_option('nodefillcol', stripslashes(strip_tags($_POST['nodefillcol'])));
		}
		if ($_POST['nodefillopacity'] != "")  {
			update_option('nodefillopacity', stripslashes(strip_tags($_POST['nodefillopacity'])));
		}
		if ($_POST['nodetextcolour'] != "")  {
			update_option('nodetextcolour', stripslashes(strip_tags($_POST['nodetextcolour'])));
		}
		if ($_POST['nodecornerradius'] != "")  {
			update_option('nodecornerradius', stripslashes(strip_tags($_POST['nodecornerradius'])));
		}
		if ($_POST['nodeminwidth'] != "")  {
			update_option('nodeminwidth', stripslashes(strip_tags($_POST['nodeminwidth'])));
		}
		if ($_POST['generationheight'] != "")  {
			update_option('generationheight', stripslashes(strip_tags($_POST['generationheight'])));
		}
		echo '<div class="updated"><p>'. esc_html__( 'Options saved.','wp-family-tree' ) . '</p></div>';
	}

 ?>
	<div class="wrap">
	<h2><?php esc_html_e( 'WP Family Tree Options', 'wp-family-tree' ); ?></h2>

	<a href="http://www.wpfamilytree.com/"><img width="150" height="50" alt="Visit WP Family Tree home" align="right" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/wp-family-tree/logo.jpg"/></a>

	<!--<div class="updated settings-error"><p><strong>There is now a PRO version of this plugin that offers support for larger family trees, printing, gedcom, custom fields, and more. Please visit <a target="_blank" href="http://www.wpfamilytree.com/">our website for more information</a>...</strong></p></div> -->

	<form name="ft_main" method="post">
<?php
	if (function_exists('wp_nonce_field')) {
		wp_nonce_field('family-tree-action_options');
	}
	$plugloc = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
?>
	<h3><?php esc_html_e( 'General settings', 'wp-family-tree' ); ?></h3>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="family_tree_category_key"><?php esc_html_e( 'Name of category for family members (default: "Family")', 'wp-family-tree' ); ?></label></th>
			<td><input name="family_tree_category_key" type="text" id="family_tree_category_key" value="<?php echo wpft_options::get_option('family_tree_category_key'); ?>" size="40" /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="family_tree_link"><?php esc_html_e( 'Link to page with family tree', 'wp-family-tree' ); ?></label></th>
			<td><input name="family_tree_link" type="text" id="family_tree_link" value="<?php echo wpft_options::get_option('family_tree_link'); ?>" size="40" /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="show_biodata_on_posts_page"><?php esc_html_e( 'Show biodata info on posts pages', 'wp-family-tree' ); ?></label></th>
			<td><input name="show_biodata_on_posts_page" type="checkbox" id="show_biodata_on_posts_page" value="Y" <?php echo (wpft_options::get_option('show_biodata_on_posts_page')=='true')?' checked':''; ?> /></td>
		</tr>
	</table>

	<h3><?php esc_html_e( 'Credit link', 'wp-family-tree' ); ?></h3>
<!--<p>If you use this plugin then we would be very grateful for some appreciation. <b>Appreciation makes us happy.</b> If you don't want to link to us from the bottom of the family tree then please consider these other options - <b>i)</b> send us an <a target="_blank" href="http://www.esscotti.com/wp-family-tree-plugin">email</a> and let us know about your family tree website (that would inspire us), <b>ii)</b> include a link to <a target="_blank" href="http://www.esscotti.com">www.esscotti.com</a> from some other location of your site (that would help us feed our children), <b>iii)</b> Give us a good rating at the <a target="_blank" href="http://wordpress.org/extend/plugins/wp-family-tree/">Wordpress plugin site</a>.</p> -->
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="showcreditlink"><?php esc_html_e( 'Show powered-by link', 'wp-family-tree' ); ?></label></th>
			<td><input name="showcreditlink" type="checkbox" id="showcreditlink" value="Y" <?php echo (wpft_options::get_option('showcreditlink')=='true')?' checked':''; ?> /></td>
		</tr>
	</table>

	<h3><?php esc_html_e( 'Family tree options', 'wp-family-tree' ); ?></h3>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="bOneNamePerLine"><?php esc_html_e( 'Wrap names', 'wp-family-tree' ); ?></label></th>
			<td><input name="bOneNamePerLine" type="checkbox" id="bOneNamePerLine" value="Y" <?php echo (wpft_options::get_option('bOneNamePerLine')=='true')?' checked':''; ?> /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="bOnlyFirstName"><?php esc_html_e( 'Only show first name', 'wp-family-tree' ); ?></label></th>
			<td><input name="bOnlyFirstName" type="checkbox" id="bOnlyFirstName" value="Y" <?php echo (wpft_options::get_option('bOnlyFirstName')=='true')?' checked':''; ?> /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="bBirthAndDeathDates"><?php esc_html_e( 'Show living dates', 'wp-family-tree' ); ?></label></th>
			<td><input name="bBirthAndDeathDates" type="checkbox" id="bBirthAndDeathDates" value="Y" <?php echo (wpft_options::get_option('bBirthAndDeathDates')=='true')?' checked':''; ?> /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="bConcealLivingDates"><?php esc_html_e( 'Conceal living dates for those alive', 'wp-family-tree' ); ?></label></th>
			<td><input name="bConcealLivingDates" type="checkbox" id="bConcealLivingDates" value="Y" <?php echo (wpft_options::get_option('bConcealLivingDates')=='true')?' checked':''; ?> /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="bShowSpouse"><?php esc_html_e( 'Show spouse', 'wp-family-tree' ); ?></label></th>
			<td><input name="bShowSpouse" type="checkbox" id="bShowSpouse" value="Y" <?php echo (wpft_options::get_option('bShowSpouse')=='true')?' checked':''; ?> /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="bShowOneSpouse"><?php esc_html_e( 'Show only one spouse', 'wp-family-tree' ); ?></label></th>
			<td><input name="bShowOneSpouse" type="checkbox" id="bShowOneSpouse" value="Y" <?php echo (wpft_options::get_option('bShowOneSpouse')=='true')?' checked':''; ?> /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="bVerticalSpouses"><?php esc_html_e( 'Display spouses vertically', 'wp-family-tree' ); ?></label></th>
			<td><input name="bVerticalSpouses" type="checkbox" id="bVerticalSpouses" value="Y" <?php echo (wpft_options::get_option('bVerticalSpouses')=='true')?' checked':''; ?> /></td>
		</tr>
<!--
		<tr valign="top">
			<th scope="row"><label for="bMaidenName">Maiden name</label></th>
			<td><input name="bMaidenName" type="checkbox" id="bMaidenName" value="Y" <?php echo (wpft_options::get_option('bMaidenName')=='true')?' checked':''; ?> /></td>
		</tr>
-->
		<tr valign="top">
			<th scope="row"><label for="bShowGender"><?php esc_html_e( 'Show gender', 'wp-family-tree' ); ?></label></th>
			<td><input name="bShowGender" type="checkbox" id="bShowGender" value="Y" <?php echo (wpft_options::get_option('bShowGender')=='true')?' checked':''; ?> /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="bDiagonalConnections"><?php esc_html_e( 'Diagonal connections', 'wp-family-tree' ); ?></label></th>
			<td><input name="bDiagonalConnections" type="checkbox" id="bDiagonalConnections" value="Y" <?php echo (wpft_options::get_option('bDiagonalConnections')=='true')?' checked':''; ?> /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="bRefocusOnClick"><?php esc_html_e( 'Refocus on click', 'wp-family-tree' ); ?></label></th>
			<td><input name="bRefocusOnClick" type="checkbox" id="bRefocusOnClick" value="Y" <?php echo (wpft_options::get_option('bRefocusOnClick')=='true')?' checked':''; ?> /></td>
		</tr>
	</table>

	<h3><?php esc_html_e( 'Node navigation toolbar', 'wp-family-tree' ); ?></h3>
	<?php esc_html_e( 'Each node in the family tree can have a toolbar which can show a number of additional options. Here you can define how the toolbar should work.', 'wp-family-tree' ); ?>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="bShowToolbar"><?php esc_html_e( 'Enable toolbar', 'wp-family-tree' ); ?></label></th>
			<td><input name="bShowToolbar" type="checkbox" id="bShowToolbar" value="Y" <?php echo (wpft_options::get_option('bShowToolbar')=='true')?' checked':''; ?> /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="family_tree_toolbar_blogpage"><?php esc_html_e( 'Enable blogpage link', 'wp-family-tree' ); ?> <img src="<?php echo $plugloc; ?>open-book.png"></label></th>
			<td><input name="family_tree_toolbar_blogpage" type="checkbox" id="family_tree_toolbar_blogpage" value="Y" <?php echo (wpft_options::get_option('family_tree_toolbar_blogpage')=='Y')?' checked':''; ?> /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="family_tree_toolbar_treenav"><?php esc_html_e( 'Enable tree nav link', 'wp-family-tree' ); ?> <img src="<?php echo $plugloc; ?>tree.gif"></label></th>
			<td><input name="family_tree_toolbar_treenav" type="checkbox" id="family_tree_toolbar_treenav" value="Y" <?php echo (wpft_options::get_option('family_tree_toolbar_treenav')=='Y')?' checked':''; ?> /></td>
		</tr>
	</table>

	<h3><?php esc_html_e( 'Family tree styling', 'wp-family-tree' ); ?></h3>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="canvasbgcol"><?php esc_html_e( 'Background colour (#rgb)', 'wp-family-tree' ); ?></label></th>
			<td><input name="canvasbgcol" type="text" id="canvasbgcol" value="<?php echo wpft_options::get_option('canvasbgcol'); ?>" size="40" /></td>
		</tr>

		<tr valign="top">
			<th scope="row"><label for="nodeoutlinecol"><?php esc_html_e( 'Node outline colour (#rgb)', 'wp-family-tree' ); ?></label></th>
			<td><input name="nodeoutlinecol" type="text" id="nodeoutlinecol" value="<?php echo wpft_options::get_option('nodeoutlinecol'); ?>" size="40" /></td>
		</tr>

		<tr valign="top">
			<th scope="row"><label for="nodefillcol"><?php esc_html_e( 'Node fill colour (#rgb)', 'wp-family-tree' ); ?></label></th>
			<td><input name="nodefillcol" type="text" id="nodefillcol" value="<?php echo wpft_options::get_option('nodefillcol'); ?>" size="40" /></td>
		</tr>

		<tr valign="top">
			<th scope="row"><label for="nodefillopacity"><?php esc_html_e( 'Node opacity (0.0 to 1.0)', 'wp-family-tree' ); ?></label></th>
			<td><input name="nodefillopacity" type="text" id="nodefillopacity" value="<?php echo wpft_options::get_option('nodefillopacity'); ?>" size="40" /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="nodetextcolour"><?php esc_html_e( 'Node text colour (#rgb)', 'wp-family-tree' ); ?></label></th>
			<td><input name="nodetextcolour" type="text" id="nodetextcolour" value="<?php echo wpft_options::get_option('nodetextcolour'); ?>" size="40" /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="nodetextcolour"><?php esc_html_e( 'Node corner radius (pixels)', 'wp-family-tree' ); ?></label></th>
			<td><input name="nodecornerradius" type="text" id="nodecornerradius" value="<?php echo wpft_options::get_option('nodecornerradius'); ?>" size="40" /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="nodeminwidth"><?php esc_html_e( 'Node minimum width (pixels)', 'wp-family-tree' ); ?></label></th>
			<td><input name="nodeminwidth" type="text" id="nodeminwidth" value="<?php echo wpft_options::get_option('nodeminwidth'); ?>" size="40" /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="generationheight"><?php esc_html_e( 'Height of generations (pixels)', 'wp-family-tree' ); ?></label></th>
			<td><input name="generationheight" type="text" id="generationheight" value="<?php echo wpft_options::get_option('generationheight'); ?>" size="40" /> * This parameter is useful if spouses are displayed vertically..</td>
		</tr>
	</table>

	<p class="submit">
	<input type="hidden" name="action" value="update" />
<!--
	<input type="hidden" name="page_options" value="family_tree_category_key"/>
-->
	<input type="submit" name="update_options" class="button" value="<?php esc_html_e( 'Save Changes', 'wp-family-tree' ); ?> &raquo;" />
	</p>

	</form>
	</div>
<?php
}

class wpft_options {

	static function get_option($option) {
		$value = get_option($option);

		if ($value !== false) {
			return $value;
		}
		// Option did not exist in database so return default values...
		switch ($option) {
		case "family_tree_link":
			return '/family-tree/';	// Default link to where the family tree sits
		case "family_tree_category_key":
			return 'Family';	// Default category for posts included in the tree
		case "show_biodata_on_posts_page":
			return 'true';	// Whether or not to show table with bio data on posts page
		case "canvasbgcol":
			return '#f3f3f3';		// Background colour for tree canvas
		case "nodeoutlinecol":
			return '#05c';		// Outline colour for nodes
		case "nodefillcol":
			return '#5cf';		// Fill colour for nodes
		case "nodefillopacity":
			return '0.4';		// Node opacity (0 to 1)
		case "nodetextcolour":
			return '#000';		// Node text colour
		case "family_tree_toolbar_enable":
			return 'Y';			// Show/enable toolbar
		case "family_tree_toolbar_blogpage":
			return 'Y';			// Toolbar button for navigating to the node's blog page
		case "family_tree_toolbar_treenav":
			return 'Y';			// Toolbar button for navigating to the node's tree

		case "bOneNamePerLine":		// Wrap names
			return 'true';
		case "bOnlyFirstName":
			return 'false';
		case "bBirthAndDeathDates":
			return 'true';
		case "bConcealLivingDates":
			return 'true';
		case "bShowSpouse":
			return 'true';
		case "bShowOneSpouse":
			return 'false';
		case "bVerticalSpouses":
			return 'true';
		case "bMaidenName":
			return 'true';
		case "bShowGender":
			return 'true';
		case "bDiagonalConnections":
			return 'false';
		case "bRefocusOnClick":
			return 'false';
		case "bShowToolbar":
			return 'true';
		case "nodecornerradius":
			return '5';
		case "nodeminwidth":
			return '0';
		case "showcreditlink":
			return 'true';
		case "generationheight":
			return '100';
		}
		return '';
	}

	static function check_options() {
		$value = get_option('family_tree_link');
		if ($value === false) {
			echo '<script language="javascript">alert("' . esc_html__( 'You need to configure the WP Family Tree plugin and set the \"family tree link\" parameter in the administrator panel.\n\nThis parameter will tell the family tree plugin which page is used to display the main family tree. I.e, the page where you have put the [family-tree] shortcode.\n\n ', 'wp-family-tree') . '");</script>';
		}
	}

}

?>
