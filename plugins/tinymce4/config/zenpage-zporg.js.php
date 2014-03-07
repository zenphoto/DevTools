<?php
/**
 * The configuration functions for TinyMCE 4.x.
 *
 * Zenphoto plugin default light configuration
 */
$filehandler = zp_apply_filter('tinymce_zenpage_config', NULL);
?>
<script type="text/javascript" src="<?php echo WEBPATH . "/" . ZENFOLDER . "/" . PLUGIN_FOLDER; ?>/tinymce4/tinymce.min.js"></script>
<script type="text/javascript">
// <!-- <![CDATA[
					tinymce.init({
					selector: "textarea.content,textarea.desc,textarea.extracontent",
									language: "<?php echo $locale; ?>",
									menubar: false,
									relative_urls: false,
									style_formats: [
									{title: 'Block formats',
													items: [
													{title: 'heading 4', block: 'h4'},
													{title: 'heading 5', block: 'h5'},
													{title: 'heading 6', block: 'h6'},
													{title: 'preformatted', block: 'pre'},
													{title: 'code', block: 'code'},
													{title: 'paragraph', block: 'p'}
													]
									},
									{title: 'styles',
													items: [
													{title: 'articlebox (center)', inline: 'span', classes: 'articlebox'},
													{title: 'articlebox-left', inline: 'span', classes: 'articlebox-left'},
													{title: 'inlinecode', inline: 'span', classes: 'inlinecode'},
													{title: 'table_of_content_list', inline: 'span', classes: 'table_of_content_list'}
													]

									}
									],
									content_css: "<?php echo FULLWEBPATH . '/' . USER_PLUGIN_FOLDER; ?>/tinymce4/config/content.css",
<?php
if ($filehandler) {
	?>
						elements : "<?php echo $filehandler; ?>",
										file_browser_callback : <?php echo $filehandler; ?>,
	<?php
}
?>
					plugins: [
									"advlist autolink lists link image charmap print preview anchor",
									"searchreplace visualblocks code fullscreen",
									"insertdatetime media table contextmenu paste tinyzenpage"
					],
									toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code | fullscreen tinyzenpage",
									setup: function(ed) {
									ed.on('change', function(e) {
									$('.dirty-check').addClass('dirty');
									});
									}
					});
// ]]> -->
</script>
