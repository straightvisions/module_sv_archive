<?php if ( current_user_can( 'activate_plugins' ) ) { ?>
	<div class="sv_setting_subpages">
		<ul class="sv_setting_subpages_nav"></ul>
		<?php
			foreach($module->get_archive_types() as $slug => $label) {
				require($module->get_path('lib/tpl/settings/general.php'));
			}
			require_once( $module->get_path( 'lib/tpl/settings/extra_styles.php' ) );
		?>
	</div>
	<?php
}