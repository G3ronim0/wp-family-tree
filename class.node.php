<?php
// Copyright (c) 2010,2011 Arvind Shah
// WP Family Tree is released under the GNU General Public
// License (GPL) http://www.gnu.org/licenses/gpl.txt

class node {
	var $post_id;
	var $gender;
	var $spouse;
	var $partners;
	var $father;
	var $mother;
	var $born;
	var $died;
	var $thumbsrc;
	var $thumbhtml;

	var $children;
	var $siblings;

	var $name;
	var $name_father;
	var $name_mother;
	var $url;
	var $url_father;
	var $url_mother;

	function __construct() {
		$children = array();
	}

	static function get_node($post_detail) {
		$fm = new node();
		$fm->post_id 	= $post_detail->ID;
		$fm->name 		= $post_detail->post_title;
		$fm->url		= get_permalink($post_detail->ID);
		$fm->gender	= get_post_meta($post_detail->ID, 'gender', true);
		$fm->father	= get_post_meta($post_detail->ID, 'father', true);
		$fm->mother	= get_post_meta($post_detail->ID, 'mother', true);
		$fm->spouse	= get_post_meta($post_detail->ID, 'spouse', true);
		$fm->born	= get_post_meta($post_detail->ID, 'born', true);
		$fm->died	= get_post_meta($post_detail->ID, 'died', true);
		if (function_exists('get_post_thumbnail_id')) {
			$thumbid = get_post_thumbnail_id($post_detail->ID);
			$thumbsrc = wp_get_attachment_image_src($thumbid, 'thumbnail');
			$fm->thumbsrc = $thumbsrc[0];
			$fm->thumbhtml = get_the_post_thumbnail($post_detail->ID, 'thumbnail');
		}
		return $fm;
	}
	function get_html($the_family) {

		$html = '<table border="0" width="100%">';
		$html .= '<tr><td width="150" style="vertical-align:bottom"><b><a href="'.$this->url.'">';
		if (!empty($this->thumbhtml)) {
			$html .= "<br>".$this->thumbhtml;
		}
		$html .= $this->name.'</a></b></td>';
		$html .= '<td width="80" style="vertical-align:bottom">';
		$plugloc = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
//		$html .= ($this->gender == 'm') ? 'Male' : 'Female';
		if ($this->gender == 'm') {
			$html .= '<img alt="' . esc_html__( 'Male', 'wp-family-tree' ) . '" title="' . esc_html__( 'Male', 'wp-family-tree' ) . '" src="'.$plugloc.'icon-male-small.gif"/>';
		} else if ($this->gender == 'f') {
			$html .= '<img alt="' . esc_html__( 'Female', 'wp-family-tree' ) . '" title="' . esc_html__( 'Female', 'wp-family-tree' ) . '" src="'.$plugloc.'icon-female-small.gif"/>';
		} else {
			$html .= '<img alt="' . esc_html__( 'Gender not specified', 'wp-family-tree' ) . '" title="' . esc_html__( 'Gender not specified', 'wp-family-tree' ) . '" src="'.$plugloc.'icon-qm-small.gif"/>';
		}
//		$html .= ($this->gender == 'm') ? 'Male' : 'Female';

		$ftlink = wpft_options::get_option('family_tree_link');
		if (strpos($ftlink, '?') === false) {
			$html .=' <a href="'.$ftlink.'?ancestor='.$this->post_id.'"><img border="0" alt="' . esc_html__( 'View tree', 'wp-family-tree' ) . '" title="' . esc_html__( 'View tree', 'wp-family-tree' ) . '" src="'.$plugloc.'icon-tree-small.gif"/></a>';
		} else {
			$html .=' <a href="'.$ftlink.'&ancestor='.$this->post_id.'"><img border="0" alt="' . esc_html__( 'View tree', 'wp-family-tree' ) . '" title="' . esc_html__( 'View tree', 'wp-family-tree' ) . '" src="'.$plugloc.'icon-tree-small.gif"/></a>';
		}

		$html .= '</td>';
		$html .= '<td style="vertical-align:bottom">' . esc_html__( 'Born:', 'wp-family-tree' ) . $this->born . '</td>';
		if (!empty($this->died) && strlen($this->died) > 1) {
			$html .= '<td style="vertical-align:bottom">' . esc_html__( 'Died:', 'wp-family-tree' ) .	$this->died . '</td>';
		} else {
			$html .= '<td></td>';
		}
		$html .= '</tr>';
		$html .= '<tr><td colspan="2">' . esc_html__( 'Father:', 'wp-family-tree' );
		if (isset($this->name_father)) {
			$html .= '<a href="'.$this->url_father.'">'.$this->name_father.'</a>';
		} else {
			$html .= esc_html__( 'Unspecified' , 'wp-family-tree' );
		}
		$html .= '</td>';
		$html .= '<td colspan="2">' . esc_html__( 'Mother:', 'wp-family-tree' );
		if (isset($this->name_mother)) {
			$html .= '<a href="'.$this->url_mother.'">'.$this->name_mother.'</a>';
		} else {
			$html .= esc_html__( 'Unspecified' , 'wp-family-tree' );
		}
		$html .= '</td></tr>';
		$html .= '<tr><td colspan="4">' . esc_html__( 'Children:', 'wp-family-tree' );
		if (count($this->children) > 0) {
			$first = true;
			foreach ($this->children as $child) {
				if (!$first) {
					$html .= ', ';
				} else {
					$first = false;
				}
				$html .= '<a href="'.$the_family[$child]->url.'">'.$the_family[$child]->name.'</a>';
			}
		} else {
			$html .= esc_html__( 'none', 'wp-family-tree' );
		}
		$html .= '</td></tr>';
		$html .= '<tr><td colspan="4">' . esc_html__( 'Siblings:', 'wp-family-tree' );
		if (count($this->siblings) > 0) {
			$first = true;
			foreach ($this->siblings as $sibling) {
				if (!$first) {
					$html .= ', ';
				} else {
					$first = false;
				}
				$html .= '<a href="'.$the_family[$sibling]->url.'">'.$the_family[$sibling]->name.'</a>';
			}
		} else {
			$html .= esc_html__( 'none', 'wp-family-tree' );
		}
		$html .= '</td></tr>';
		$html .= '</table>';
		return $html;
	}
	function get_toolbar_div() {
		$plugloc = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
		$ftlink = wpft_options::get_option('family_tree_link');

		if (strpos($ftlink, '?') === false) {
			$ftlink = $ftlink.'?ancestor='.$this->post_id;
		} else {
			$ftlink = $ftlink.'&ancestor='.$this->post_id;
		}
		$permalink = get_permalink($this->post_id);
		$html = '';

		if (wpft_options::get_option('bShowToolbar') == 'true') {
			$html .= '<div class="toolbar" id="toolbar'.$this->post_id.'">';
			if (wpft_options::get_option('family_tree_toolbar_blogpage') == 'Y') {
				$about_title = sprintf( esc_html_x( 'View information about %s.', 'The lastname', 'wp-family-tree' ), htmlspecialchars($this->name) );
				$html .= '<a class="toolbar-blogpage" href="'.$permalink.'" title="' . $about_title . '"><img border="0" class="toolbar-blogpage" src="'.$plugloc.'open-book.png"></a>';
			}
			if (wpft_options::get_option('family_tree_toolbar_treenav') == 'Y') {
				$family_view_title = sprintf( esc_html_x( 'View the family of %s.', 'The lastname', 'wp-family-tree' ), htmlspecialchars($this->name) );
				$html .= '<a class="toolbar-treenav" href="'.$ftlink.'" title="' . $family_view_title . '"><img border="0" class="toolbar-treenav" src="'.$plugloc.'tree.gif"></a>';
			}
			if (!empty($this->thumbsrc)) {
				$html .= '<img border="0" class="toolbar-treenav" src="'.$plugloc.'camera.gif">';
			}
			$html .= '</div>';
		}
		return $html;
	}

	function get_thumbnail_div() {
		$plugloc = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

		$html = '';
		$html .= '<div class="wpft_thumbnail" id="thumbnail'.$this->post_id.'">';
//		$html .= 'Thumbnail-'.$this->post_id;
		if (!empty($this->thumbsrc)) {
			$html .= '<img src="'.$this->thumbsrc.'">';
		}
		$html .= '</div>';

		return $html;
	}


	function get_box_html($the_family) {
		$html = '';
		$html .= '<a href="'.$this->url.'">'.$this->name.'</a>';
		$html .= '<br>' . esc_html__('Born:', 'wp-family-tree' ) . $this->born;
		if (!empty($this->died) && strlen($this->died) > 1) {
			$html .= '<br>' . esc_html__('Died:', 'wp-family-tree' ) .	$this->died;
		}

		return $html;

	}
}


?>
