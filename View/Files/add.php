<?php
/**
 * View template for adding files in admin context.
 *
 * @author Midori Kocak 2014
 *
 */
?>

<form action="<?= LINK_PREFIX ?>/Files/add" method="post"
	enctype="multipart/form-data">
	<div class="row">
		<div class="large-12 columns">
			<label>File <input type="file" id="file" name="file" />
			</label>
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<button type="submit">Submit</button>
		</div>
	</div>
</form>
