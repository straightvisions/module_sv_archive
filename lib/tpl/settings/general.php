<?php if ( current_user_can( 'activate_plugins' ) ) { ?>
<div class="sv_setting_subpage">
	<h2><?php echo $label; ?></h2>
	<h3 class="divider"><?php _e( 'Parts', 'sv100' ); ?></h3>
	<div class="sv_setting_flex">
		<?php
			echo $module->get_setting( $slug.'_show_header' )->form();
			echo $module->get_setting( $slug.'_show_footer' )->form();
			echo $module->get_setting( $slug.'_show_empty' )->form();
			echo $module->get_setting( $slug.'_show_featured_image' )->form();
			echo $module->get_setting( $slug.'_show_title' )->form();
			echo $module->get_setting( $slug.'_show_excerpt' )->form();
			echo $module->get_setting( $slug.'_show_read_more' )->form();
			echo $module->get_setting( $slug.'_show_author' )->form();
			echo $module->get_setting( $slug.'_show_date' )->form();
			echo $module->get_setting( $slug.'_show_date_modified' )->form();
			echo $module->get_setting( $slug.'_show_categories' )->form();
			echo $module->get_setting( $slug.'_show_sidebar_top' )->form();
			echo $module->get_setting( $slug.'_show_sidebar_right' )->form();
			echo $module->get_setting( $slug.'_show_sidebar_bottom' )->form();
			echo $module->get_setting( $slug.'_show_sidebar_left' )->form();
		?>
	</div>
	<h3 class="divider"><?php _e( 'Common', 'sv100' ); ?></h3>
	<div class="sv_setting_flex">
		<?php
			echo $module->get_setting( $slug.'_template' )->form();
			echo $module->get_setting( $slug.'_stack_active' )->form();
			echo $module->get_setting( $slug.'_max_width_wrapper_outer' )->form();
			echo $module->get_setting( $slug.'_max_width_wrapper_inner' )->form();
			echo $module->get_setting( $slug.'_font' )->form();
			echo $module->get_setting( $slug.'_font_size' )->form();
			echo $module->get_setting( $slug.'_line_height' )->form();
			echo $module->get_setting( $slug.'_text_color' )->form();
			echo $module->get_setting( $slug.'_bg_color' )->form();
			echo $module->get_setting( $slug.'_column_spacing' )->form();
			echo $module->get_setting( $slug.'_margin' )->form();
			echo $module->get_setting( $slug.'_padding' )->form();
			echo $module->get_setting( $slug.'_border' )->form();
		?>
	</div>
	<h3 class="divider"><?php _e( 'Entry', 'sv100' ); ?></h3>
	<div class="sv_setting_flex">
		<?php
			echo $module->get_setting( $slug.'_entry_bg_color' )->form();
			echo $module->get_setting( $slug.'_entry_margin' )->form();
			echo $module->get_setting( $slug.'_entry_padding' )->form();
			echo $module->get_setting( $slug.'_entry_border' )->form();
		?>
	</div>
	<?php
		$template = $module->get_loaded_template($slug);

		foreach($template->get_parts() as $part => $properties){
			if($part === 'common' || boolval($module->get_setting( $slug.'_show_'.$part )->get_data()) !== true) {
				continue;
			}

			echo '<h3 class="divider">'.__($properties['label'],'sv100').'</h3>';
			echo '<div class="sv_setting_flex">';
			echo $module->get_setting($slug . '_' . $part . '_order')->form();
			echo $module->get_setting($slug . '_' . $part . '_font')->form();
			echo $module->get_setting($slug . '_' . $part . '_font_size')->form();
			echo $module->get_setting($slug . '_' . $part . '_line_height')->form();
			echo $module->get_setting($slug . '_' . $part . '_text_color')->form();
			echo $module->get_setting($slug . '_' . $part . '_bg_color')->form();
			echo $module->get_setting($slug . '_' . $part . '_text_color_hover')->form();
			echo $module->get_setting($slug . '_' . $part . '_bg_color_hover')->form();
			echo '</div>';
			echo '<div class="sv_setting_flex">';
			echo $module->get_setting($slug . '_' . $part . '_margin')->form();
			echo $module->get_setting($slug . '_' . $part . '_padding')->form();
			echo '</div>';
			echo '<div class="sv_setting_flex">';
			echo $module->get_setting($slug . '_' . $part . '_border')->form();
			echo '</div>';
		}
	?>
</div>
<?php } ?>