<?php if ( current_user_can( 'activate_plugins' ) ) { ?>
	<div class="sv_setting_subpage">
		<h2><?php _e('Extra Styles', 'template_sv_archive_list'); ?></h2>
		<div class="sv_section_description"><?php echo __('Create unlimited extra styles and select them within term settings to override default styles, e.g. for a specific category.','template_sv_archive_list') ?></div>
		<div class="sv_setting_flex">
			<?php
				echo $module->get_setting('extra_styles' )->form();
			?>
		</div>
	</div>
<?php } ?>