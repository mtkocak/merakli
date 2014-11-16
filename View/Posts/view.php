<?php
/**
 * One post is shown using this layout
 * Raw data will be injected here as $post variable and handled by this layout.
 *
 * @author Midori Kocak 2014
 *
 */
?>
<article>
	<h2><?php echo $post['title']; ?></h2>

	<p><?= $post['content'] ?></p>
	<small><?= $post['created'] ?></small>
</article>


