<div class="sv_setting_subpage">
	<h2><?php echo $label; ?></h2>
	<h3 class="divider"><?php _e( 'Parts', 'sv100' ); ?></h3>
	<div class="sv_setting_flex">
		<?php
			echo $module->get_setting( $slug.'_template' )->form();
			echo $module->get_setting( $slug.'_show_featured_image' )->form();
			echo $module->get_setting( $slug.'_show_title' )->form();
			echo $module->get_setting( $slug.'_show_excerpt' )->form();
			echo $module->get_setting( $slug.'_show_read_more' )->form();
			echo $module->get_setting( $slug.'_show_date' )->form();
			echo $module->get_setting( $slug.'_show_date_modified' )->form();
			echo $module->get_setting( $slug.'_show_categories' )->form();
		?>
    </div>
</div>