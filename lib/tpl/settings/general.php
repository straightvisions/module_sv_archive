<div class="sv_setting_subpage">
	<h2><?php echo $label; ?></h2>
	<h3 class="divider"><?php _e( 'Parts', 'sv100' ); ?></h3>
	<div class="sv_setting_flex">
		<?php
			echo $module->get_setting( $slug.'_template' )->form();
			echo $module->get_setting( $slug.'_show_header' )->form();
			echo $module->get_setting( $slug.'_show_footer' )->form();
			echo $module->get_setting( $slug.'_show_empty' )->form();
			echo $module->get_setting( $slug.'_show_featured_image' )->form();
			echo $module->get_setting( $slug.'_show_title' )->form();
			echo $module->get_setting( $slug.'_show_excerpt' )->form();
			echo $module->get_setting( $slug.'_show_read_more' )->form();
			echo $module->get_setting( $slug.'_show_date' )->form();
			echo $module->get_setting( $slug.'_show_date_modified' )->form();
			echo $module->get_setting( $slug.'_show_categories' )->form();
		?>
    </div>
	<?php
		$template = $module->get_loaded_template($slug);

		foreach($template->get_parts() as $part => $properties){
			if(boolval($module->get_setting( $slug.'_show_'.$part )->get_data()) === true) {
				echo '<h3 class="divider">' . __('Part', 'sv100') . ' ' . $properties['label'] . '</h3>';
				echo '<div class="sv_setting_flex">';
				echo $module->get_setting($slug . '_' . $part . '_font')->form();
				echo $module->get_setting($slug . '_' . $part . '_font_size')->form();
				echo $module->get_setting($slug . '_' . $part . '_line_height')->form();
				echo $module->get_setting($slug . '_' . $part . '_text_color')->form();
				echo '</div>';
				echo '<div class="sv_setting_flex">';
				echo $module->get_setting($slug . '_' . $part . '_margin')->form();
				echo $module->get_setting($slug . '_' . $part . '_padding')->form();
				echo '</div>';
				echo '<div class="sv_setting_flex">';
				echo $module->get_setting($slug . '_' . $part . '_border')->form();
				echo '</div>';
			}
		}
	?>
</div>