<?php
/**
 * Plugin Name.
 *
 * @package   Exxica
 * @author    Gaute Rønningen <gaute@exxica.com>
 * @link      http://exxica.com
 * @copyright 2014 Exxica AS
 */

/**
 * Plugin class.
 *
 * @package Exxica_TodoLibrary_Admin
 * @author  Gaute Rønningen <gaute@exxica.com>
 */
class Exxica_TodoLibrary_Admin {

	protected static $instance = null;
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		$plugin = Exxica_Todo::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();
	}
	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function add_button($id, $title, $url = '#', $style = 'margin: 2px 2px 0 0;' ) {
		submit_button( __( $title, $this->plugin_slug ) , $type = 'small', $id, $wrap = false, $other_attributes = array( 'style' => $style ) );
	}


	public function general_button( $args ) {
		$id = $args['id'];
		$title = $args['title'];
		$url = isset($args['url']) ? $args['url'] : '#';
		$class = isset($args['class']) ? $args['class'] : 'exxica-grey-btn';
		$isShortcode = isset($args['isShortcode']) ? $args['isShortcode'] : false;
		$style = isset($args['style']) ? $args['style'] : 'margin: 2px 2px 5px 2px;';
		$target = isset($args['target']) ? $args['target'] : '_parent';
		$formatStr = '<a id="%s" class="%s" name="%s" style="%s" href="%s" rel="nofollow" target="%s">%s</a>';

		if($isShortcode) {
			return sprintf(
				$formatStr,
				$id, $class, $id, $style, $url, $target, $title
			);
		} else {
			printf(
				$formatStr,
				$id, $class, $id, $style, $url, $target, $title
			);
		}
	}


	public function addHTML_header( $args ) {
		$hnum = $args['hnum'];
		$value = $args['value'];
		$isShortcode = isset($args['isShortcode']) ? $args['isShortcode'] : false;
		$formatStr = '<h%d>%s</h%d>';

		if($isShortcode) {
			return sprintf(
				$formatStr,
				$hnum, $value, $hnum
			);
		} else {
			printf(
				$formatStr,
				$hnum, $value, $hnum
			);
		}
	}


	public function addHTML_input_text( $args ) {
		$id = isset($args['id']) ? $args['id'] : false;
		$value = isset($args['value']) ? $args['value'] : false;
		$name = isset($args['name']) ? $args['name'] : $id ;

		if($id) {
			$label = isset($args['label']) ? $args['label'] : '';
			$size = isset($args['size']) ? $args['size'] : 30;
			$tooltip = isset($args['tooltip']) ? ' title="'.$args['tooltip'].'"' : '';
			$extra = isset($args['extra_text']) ? $args['extra_text'] : '';
			$output = '';
			$required = isset($args['required']) ? $args['required'] : false;
			$disabled = isset($args['disabled']) ? $args['disabled'] : false;
			$locked = isset($args['locked']) ? $args['locked'] : false;

			$isShortcode = isset($args['isShortcode']) ? $args['isShortcode'] : false;
			if($label !== '') {
				$formatStr = '<label for="%s">%s</label><br/>';
				$output .= sprintf($formatStr, $id, $label);
			}
			$formatStr = '<input id="%s" class="widefat" style="margin-bottom: 5px;" type="text" value="%s" size="%s" name="%s" autocomplete="off"%s%s%s%s /><br/>%s';
			$output .= sprintf($formatStr, $id, $value, $size, $name, $tooltip, ($required) ? ' required': '', ($disabled) ? ' disabled': '', ($locked) ? ' readonly': '', ($extra !='') ? '<p style="font-size:12px;font-variant:italic;">'.$extra.'</p>' : '');

			if($isShortcode) {
				return $output;
			} else {
				echo $output;
			}
		}
	}


	public function addHTML_display_text( $args ) {
		$id = $args['id'];
		$spanvalue = $args['spanvalue'];
		$spanlabel = isset($args['spanlabel']) ? $args['spanlabel'].': ' : '';
		$extra = isset($args['extra']) ? $args['extra'] : '';

		$isShortcode = isset($args['isShortcode']) ? $args['isShortcode'] : false;
		$formatStr = '<div id="display-%s" class="widefat">%s<span id="%s">%s</span> %s</div>';

		if($isShortcode) {
			return sprintf(
				$formatStr,
				$id, $spanlabel, $id, $spanvalue, $extra
			);
		} else {
			printf(
				$formatStr,
				$id, $spanlabel, $id, $spanvalue, $extra
			);
		}
	}

	public function addHTML_textarea( $args ) {
		$id = $args['id'];
		$value = $args['value'];
		$output = '';
		$label = isset($args['label']) ? $args['label'] : '';
		$isShortcode = isset($args['isShortcode']) ? $args['isShortcode'] : false;
		$extra = isset($args['extra_text']) ? $args['extra_text'] : '';
		$tooltip = isset($args['tooltip']) ? ' title="'.$args['tooltip'].'"' : '';
		$required = isset($args['required']) ? $args['required'] : false;

		if($label !== '') {
			$formatStr = '<label for="%s">%s</label><br/>';
			$output .= sprintf($formatStr, $id, $label);
		}
		$formatStr = '<textarea id="%s" class="widefat" style="margin-bottom: 5px;" name="%s" autocomplete="off"%s%s >%s</textarea><br/><p style="font-size:12px;font-variant:italic;">%s</p>';
		$output .= sprintf($formatStr, $id, $id, $tooltip, ($required) ? ' required': '', $value, $extra);

		if($isShortcode) {
			return $output;
		} else {
			echo $output;
		}
	}


	public function addHTML_hidden( $args ) {
		/*$id = $args['id'];
		$value = $args['value'];
		$isShortcode = isset($args['isShortcode']) ? $args['isShortcode'] : false;

		$formatStr = '<input id="%s" name="%s" type="hidden" value="%s" /><br/>';

		if($isShortcode) {
			return sprintf(
				$formatStr,
				$id, $id, $value
			);
		} else {
			printf(
				$formatStr,
				$id, $id, $value
			);
		}*/
	}


	public function addHTML_input_password( $args ) {
		$id = $args['id'];
		$value = $args['value'];
		$label = isset($args['label']) ? $args['label'] : '';
		$size = isset($args['size']) ? $args['size'] : 30;
		$tooltip = isset($args['tooltip']) ? ' title="'.$args['tooltip'].'"' : '';
		$isShortcode = isset($args['isShortcode']) ? $args['isShortcode'] : false;
		$required = isset($args['required']) ? $args['required'] : false;
		$output = '';

		$formatStr = '<label for="%s">%s</label><br/><input id="%s" class="widefat" style="margin-bottom: 5px;" type="password" value="%s" size="%s" name="%s" autocomplete="off"%s%s /><br/>';
		$output .= sprintf($formatStr, $id, $label, $id, $value, $size, $id, $tooltip, ($required) ? ' required': '');

		if($isShortcode) {
			return $output;
		} else {
			echo $output;
		}
	}


	public function addHTML_radio( $args ) {
		$id = $args['id'];
		$options = $args['options'];
		$label = isset($args['label']) ? $args['label'] : '';
		$extra = isset($args['extra_text']) ? $args['extra_text'] : '';
		$isShortcode = isset($args['isShortcode']) ? $args['isShortcode'] : false;

		$output = sprintf(
			'<label for="%s">%s</label><br/>',
			$id, $label
		);
		$output .= '<div class="radio">';
		foreach($options as $item) {
			$output .= sprintf(
				'<input id="%s" type="radio" name="%s" value="%s"%s>%s<br/>',
				$item['id'], $item['name'], $item['value'], ($item['selected']) ? ' selected' : '', $item['label']
			);
		}
		if( $extra !== '' ) {
			$output .= sprintf(
				'<p style="font-size:12px;font-variant:italic;">%s</p>',
				$extra
			);
		}
		$output .= '</div>';

		if($isShortcode) {
			return $output;
		} else {
			echo $output;
		}
	}


	public function addHTML_check( $args ) {
		$output = '';
		$id = $args['id'];
		$options = $args['options'];
		$label = isset($args['label']) ? $args['label'] : '';
		$extra = isset($args['extra_text']) ? $args['extra_text'] : '';
		$isShortcode = isset($args['isShortcode']) ? $args['isShortcode'] : false;

		if( $label !== '' ) {
			$output .= sprintf(
				'<label for="%s">%s</label><br/>',
				$id, $label
			);
		}

		$output .= '<div class="checkbox">';
		foreach($options as $item) {
			$output .= sprintf(
				'<input id="%s" type="checkbox" name="%s" value="%s"%s>%s',
				$item['id'], $item['id'], $item['value'], ($item['checked']) ? ' checked': '', $item['label']
			);
		}
		if( $extra !== '' ) {
			$output .= sprintf(
				'<p style="font-size:12px;font-variant:italic;">%s</p>',
				$extra
			);
		}
		$output .= '</div>';

		if($isShortcode) {
			return $output;
		} else {
			echo $output;
		}
	}


	public function addHTML_select( $args ) {
		$id = $args['id'];
		$value = $args['value'];
		$options = $args['options'];
		$label = isset($args['label']) ? $args['label'] : '';
		$extra = isset($args['extra_text']) ? $args['extra_text'] : '';
		$size = isset($args['size']) ? $args['size'] : 5;

		$isShortcode = isset($args['isShortcode']) ? $args['isShortcode'] : false;

		$opt_group = '';
		$output = sprintf(
			'<label for="%s">%s</label><br/><select id="%s" name="%s" size="%s" class="widefat">',
			$id, $label, $id, $id, $size
		);
		foreach($options as $item) {
			if( isset( $item['optgroup'] ) ) {
				// Has optiongroups
				if($opt_group !== $item['optgroup']) $output .= sprintf( '<optgroup label="%s">', $item['optgroup'] );
				foreach($item['options'] as $r) {
					$output .= sprintf(
						'<option value="%s"%s>%s</option>',
						$r['value'], ($r['selected']) ? ' selected' : '', $r['label']
					);
				}
				if($opt_group !== $item['optgroup']) $output .= '</optgroup>';
				$opt_group = $item['optgroup'];
			} else {
				// Does not have optiongroups
				$output .= sprintf(
					'<option value="%s"%s>%s</option>',
					$item['value'], ($item['selected']) ? ' selected' : '', $item['label']
				);
			}
		}
		$output .= '</select>';
		if( $extra !== '' ) {
			$output .= sprintf(
				'<p style="font-size:12px;font-variant:italic;">%s</p>',
				$extra
			);
		}

		if($isShortcode) {
			return $output;
		} else {
			echo $output;
		}
	}


	public function addHTML_combo( $args ) {
		$id = $args['id'];
		$options = $args['options'];
		$label = isset($args['label']) ? $args['label'] : '';
		$extra = isset($args['extra_text']) ? $args['extra_text'] : '';

		$isShortcode = isset($args['isShortcode']) ? $args['isShortcode'] : false;

		$opt_group = '';
		$output = sprintf(
			'<label for="%s">%s</label><br/><select id="%s" name="%s" class="widefat">',
			$id, $label, $id, $id
		);
		foreach($options as $item) {
			if( isset($item['optgroup'] ) ) {
				// Has optiongroups
				if($opt_group !== $item['optgroup']) $output .= sprintf( '<optgroup label="%s">', $item['optgroup'] );
				foreach($item['options'] as $r) {
					$output .= sprintf(
						'<option value="%s"%s>%s</option>',
						$r['value'], ($r['selected']) ? ' selected' : '', $r['label']
					);
				}
				if($opt_group !== $item['optgroup']) $output .= '</optgroup>';
				$opt_group = $item['optgroup'];
			} else {
				// Does not have optiongroups
				$output .= sprintf(
					'<option value="%s"%s>%s</option>',
					$item['value'], ($item['selected']) ? ' selected' : '', $item['label']
				);
			}
		}
		$output .= '</select>';
		if( $extra !== '' ) {
			$output .= sprintf(
				'<p style="font-size:12px;font-variant:italic;">%s</p>',
				$extra
			);
		}

		if($isShortcode) {
			return $output;
		} else {
			echo $output;
		}
	}


	public function addHTML_range( $args ) {
		$id = $args['id'];
		$default = $args['default'];
		$min = $args['min'];
		$max = $args['max'];
		$step = isset($args['step']) ? $args['step'] : 1;
		$label = isset($args['label']) ? $args['label'] : '';
		$extra = isset($args['extra']) ? ' '.$args['extra'] : ' cm';
		$isShortcode = isset($args['isShortcode']) ? $args['isShortcode'] : false;

		$formatStr = '<label style="font-weight:bold;" for="%s">%s</label><br/><input id="%s" class="widefat" style="margin-bottom: 5px;" type="range" value="%s" name="%s" autocomplete="off" min="%s" max="%s" step="%d" /><br/><center><p style="font-size:14pt;font-variant:italic;"><span id="%s-extra">%s</span>%s</p></center>';
		if($isShortcode) {
			return sprintf(
				$formatStr,
				$id, $label, $id, $default, $id, $min, $max, $step, $id, $default, $extra
			);
		} else {
			printf(
				$formatStr,
				$id, $label, $id, $default, $id, $min, $max, $step, $id, $default, $extra
			);
		}
	}


	public function validateInput( $id, $nonce = array( 'compareKey' => null, 'compareValue' => null), $user_can = 'edit_post') {
		if ( ! is_null( $nonce['compareValue'] ) && ! isset( $nonce['compareValue'] ) ) return false;

	  	if ( ! wp_verify_nonce( $nonce['compareValue'], $nonce['compareKey'] ) ) return false;

	  	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return false;

	  	if ( !current_user_can($user_can, $id) ) return false;

		if ( wp_is_post_revision( $id ) ) return false;

		return true;
	}
}