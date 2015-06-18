<?php
/**
 * This file control open container block
 *
 * @package    OneEngine
 * @package    EngineThemes
 */

if( ! class_exists( 'OE_Open_Container_Block') ) :

class OE_Open_Container_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
			'name' 		=> 'Container (open)',
			'size' 		=> 'span12',
			'resizable' => 0,
		);		
		parent::__construct( 'OE_Open_Container_Block', $block_options );
	}
	
	function form( $instance ){
		$defaults = array(
			'bg_color' 				=> '#fafafa',
			'position' 				=> 'top left',
			'image' 				=> '',
			'repeat'				=> 'repeat',
			'text_color'			=> 'normal',
			'parallax' 				=> '',
			'padding_top'			=> '0',
			'padding_bottom'		=> '0',
			'show_row'				=> 'true',
			'video_bg'				=> 'true',
			'menu_id'				=> '',
			'video_link'			=> '',
			'text'       			=> '',
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		$text_colors = array(
			'white' 	=> 'Color White',
			'normal' 	=> 'Color Default'
		);
		
		$bg_repeat = array(
			'repeat'	=> 'repeat',
			'no-repeat' => 'no-repeat'
		);
		
		$row = array(
			'true'	=> 'Yes',
			'false' => 'No'
		);
		$menus_arr = array(''=>'-- Select --');

		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'main_nav' ] ) ) {
		    $menu = wp_get_nav_menu_object( $locations[ 'main_nav' ] );
		    $menu_items = wp_get_nav_menu_items($menu->term_id);
			if(!empty( $menu_items )){
				foreach ($menu_items as $menu_item) {
					$menus_arr[sanitize_title($menu_item->title)] = $menu_item->title;
				}
			}    
		}

		?>
        <p class="description">
			<label for="<?php echo $this->get_field_id( 'padding_top' ) ?>">
				<?php _e( 'Padding top', 'oneengine');?>
				<?php echo aq_field_input( 'padding_top', $block_id, $padding_top, $size = 'min', $type = 'number' ) ?>px
            </label>
            &nbsp;&nbsp;-&nbsp;&nbsp;
			<label for="<?php echo $this->get_field_id( 'padding_bottom' ) ?>">
				<?php _e( 'Padding Bottom', 'oneengine');?>
				<?php echo aq_field_input( 'padding_bottom', $block_id, $padding_bottom, $size = 'min', $type = 'number' ) ?>px
            </label>
		</p>
        <p class="description">
			<label for="<?php echo $this->get_field_id('text_color') ?>">
				<?php _e( 'Text color', 'oneengine');?>
				<?php echo aq_field_select('text_color', $block_id, $text_colors, $text_color) ?>
			</label>
		</p>
		<p class="description">
			<label for="<?php echo $this->get_field_id('image') ?>">
				<?php _e( 'Background Image', 'oneengine');?>
				<?php echo aq_field_upload('image', $block_id, $image, $media_type = 'image') ?>
			</label>
		</p>		

        <p class="description"> <!--Videolink-->
			<label for="<?php echo $this->get_field_id('video_link') ?>">
				<?php _e( 'Video Link', 'oneengine');?>
				<?php echo aq_field_input('video_link', $block_id, $video_link, $size = 'full') ?>
			</label>
		</p>
        
        <p class="description"> <!--Content-->
			<label for="<?php echo $this->get_field_id('text') ?>">
				<?php _e('Content', 'oneengine'); ?>
				<?php echo aq_field_textarea('text', $block_id, $text, $size = 'full') ?>
			</label>
		</p>

        <p class="description">
			<label for="<?php echo $this->get_field_id('bg_color') ?>">
				<?php _e( 'Background Color (Ex : #fafafa;)', 'oneengine');?>
                <?php echo aq_field_color_picker('bg_color', $block_id, $bg_color) ?>
			</label>
		</p>
        <p class="description">
			<label for="<?php echo $this->get_field_id('position') ?>">
				<?php _e( 'Background position', 'oneengine');?>
				<?php echo aq_field_input('position', $block_id, $position, $size = 'small') ?>
			</label>
		</p>
        <p class="description">
			<label for="<?php echo $this->get_field_id('repeat') ?>">
				<?php _e( 'Background repeat ?', 'oneengine');?>
				<?php echo aq_field_select('repeat', $block_id, $bg_repeat, $repeat) ?>
			</label>
		</p>
        <p class="description">
			<label for="<?php echo $this->get_field_id('parallax') ?>">
				<?php _e( 'Background parallax ?', 'oneengine');?>
				<?php echo aq_field_checkbox('parallax', $block_id, $parallax) ?>
			</label>
		</p>
        <p class="description">
			<label for="<?php echo $this->get_field_id('show_row') ?>">
				<?php _e( 'Show/hide section "row" (if you add block item fullwidth here, please choose "No" for 2 block "Container (open)" and "Container (close)")', 'oneengine');?>
				<?php echo aq_field_select('show_row', $block_id, $row, $show_row) ?>
			</label>
		</p>
        <p class="description">
			<label for="<?php echo $this->get_field_id('menu_id') ?>">
				<?php _e( 'Select the block’s ID to link with the Menu header.', 'oneengine');?>
				<?php echo aq_field_select('menu_id', $block_id, $menus_arr, $menu_id) ?>
			</label>
		</p>	
		<?php
	}
	
	function block( $instance ) {
		extract( $instance );
		$menu_id        = ( ! empty ( $menu_id )) ? $menu_id : '';
		$image			= ( ! empty ( $image ) ) ? 'background-image:url('. $image .');' : '';
		$bg_color		= ( ! empty ( $bg_color ) ) ? 'background-color:'. $bg_color .';' : '';
		$position 		= ( ! empty ( $position ) ) ? 'background-position:'. $position .';' : '';
		$repeat 		= ( ! empty ( $repeat ) ) ? 'background-repeat:'. $repeat .';': '';
		$padding_bottom = ( ! empty ( $padding_bottom ) ) ? 'padding-bottom:'. (int)$padding_bottom .'px;': '';
		$padding_top 	= ( ! empty ( $padding_top ) ) ? 'padding-top:'. (int)$padding_top .'px;': '';
		$video_bg 		= ( ! empty ( $video_bg ) ) ? 'display:block; margin: auto; background: rgba(0,0,0,0.5);': '';
		$parallax 		= ( ! empty ( $parallax ) ) ? 'background-attachment: fixed;': '';
		$video_play 	= ( ! empty ( $video_link ) ) ? '<video class="bgvid" style="width:100%;height:100;" controls><source src="'.$video_link.'" type="video/mp4"><source src="'.$video_link.'" type="video/webm"></video>': '';
		$text        = ( ! empty ( $text )) ? $text : '';
		
		/** Style Parallax */
		$style_wrapper = ( 
			! empty( $padding_bottom ) ||
			! empty( $padding_top ) ) ? 
				sprintf( '%s %s', $padding_bottom, $padding_top) : '';
		$css_wrapper= '';
		if ( ! empty( $style_wrapper ) ) {			
			$css_wrapper= 'style="'. $style_wrapper .'" ';
		}
		
		/** Style Parallax */
		$style = ( 
			! empty( $image ) ||
			! empty( $bg_color ) ||
			! empty( $position ) || 
			! empty( $repeat ) ||
			! empty( $parallax ) ) ? 
				sprintf( '%s %s %s %s %s', $image, $bg_color, $position, $repeat, $parallax ) : '';
		$css_parallax = '';
		if ( ! empty( $style ) ) {			
			$css_parallax = 'style="'. $style .'" ';
		}
		/** Text Color Container ***/
		$white_color = '';
		if ( $text_color == 'white' ){ $white_color = ' color-white' ; }
		/** Parallax Background ***/
		$bg_parallax='';
		//if($parallax == 1 || $parallax == 'true') $bg_parallax = 'style="background-attachment: fixed;"'; else $bg_parallax = '';
		/** Video Background **/
		$video = '';
		//if($video_bg == 1 || $video_bg == 'true') $video = 'data-property="{videoURL:\''.$video_link.'\',containment:\'self\',startAt:50,mute:true,autoPlay:false,loop:false,opacity:.8}"'; else $video = '';
		
        $output .= do_shortcode(htmlspecialchars_decode('<p class="'.$animation_effect.'" style="font-size:'.$font_size.'px;margin-top:'.$margin_top.'px;margin-bottom:'.$margin_bottom.'px; text-align:'.$align.'; '.$duration_effect.'">'.$text.'</p>'));
        
		/** Show row <div class="parallax" '.$css.'></div>***/
		$row_class = '';
		if ( $show_row == 'true' ){ $row_class = '<div class="container"><div class="row">' ; }
		
		echo '<div id="'.$menu_id.'" class=" template-wrap cf'.$white_color.'" '.$css_wrapper.' >
		<div class="parallax" '.$css_parallax.'></div>'.$video_play.'
        '.$output.'
		'.$row_class.'';
	}

	function before_block( $instance ) {
		extract( $instance );
		return;
	}

	function after_block( $instance ) {
		extract( $instance );
		return;
	}
 	
}

aq_register_block( 'OE_Open_Container_Block' );

endif;