<?php
global $post;

echo $is_breaking_news   = get_post_meta( $post->ID, 'is_breaking_news', true );
echo $bnews_custom_title = get_post_meta( $post->ID, 'bnew_custom_title', true );
?>
<div class="bnews-meta-box">
	<p class = "options-row">
		<label for = "is_breaking_news">
			<?php echo __( 'Make this post breaking news', $this->text_domain );?>
		</label>
		<input
			id   = "is_breaking_news"
			name = "is_breaking_news"
			type = "checkbox" <?php echo checked( 'on', $is_breaking_news ); ?> />
	</p>

	<p class = "options-row">
		<label for = "bnews_custom_title">
            <span class= "label"><?php echo __( 'Breaking News Custom Title', $this->text_domain );?></span>
			<span class="description"><?php echo __( 'Leave empty to use default post title,', $this->text_domain )?></span>
		</label>
		<input
			id    = "bnews_custom_title"
			name  = "bnews_custom_title"
			type  = "text"
			value = "<?php echo esc_attr( $bnews_custom_title ); ?>"/>
	</p>
</div>