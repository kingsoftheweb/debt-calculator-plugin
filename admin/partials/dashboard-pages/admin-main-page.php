<?php
if ( isset( $_POST['save_breaking_news'] ) && current_user_can('manage_options') ) {

    $inputs = [
            'breaking_news_title',
            'background_color',
            'text_color'
    ];

    foreach ( $inputs as $input ) {

        if( isset( $_POST[$input] ) ) {
            $value = sanitize_text_field( $_POST[$input] );
            update_option( $this->prefix . '['.$input.']', $value );
        }

    }
}

$breaking_news_title = get_option( $this->prefix . '[breaking_news_title]' );
$background_color    = get_option( $this->prefix . '[background_color]' );
$text_color          = get_option( $this->prefix . '[text_color]' );
?>
<div class="bnews-admin-screen">
    <h1 class="plugin-title"><?php echo __( 'Breaking News', $this->text_domain ); ?></h1>
    <h3 class="plugin-sub-title"><?php echo __( 'Developed by ', $this->text_domain );?> Mazen Hesham</h3>


    <div class="bnews-admin-section">
        <div class="section-header">
            <h2><?php echo __( 'Breaking News Settings', $this->text_domain ); ?></h2>
        </div>
        <div class="section-content">
            <form method = "post">
                <p class="options-row">
                    <label for = "breaking_news_title">
                        <span class="label"><?php echo __( 'Breaking News Title', $this->text_domain );?></span>
                        <span class="description"></span>
                    </label>
                    <input
                            id    = "breaking_news_title"
                            name  = "breaking_news_title"
                            value = "<?php echo esc_attr( $breaking_news_title ); ?>"/>
                </p>

                <p class="options-row">
                    <label for = "background_color">
                        <span class="label"><?php echo __( 'Background Color', $this->text_domain ); ?></span>
                        <span class="description"><?php echo __( 'Background post color. ' ); ?></span>
                    </label>
                    <input
                            id    = "background_color"
                            type  = "color"
                            name  = "background_color"
                            value = "<?php echo esc_attr( $background_color ); ?>"/>
                </p>

                <p class="options-row">
                    <label for = "text_color">
                        <span class="label"><?php echo __( 'Text Color', $this->text_domain ); ?></span>
                        <span class="description"><?php echo __( 'Post text color. ' ); ?></span>
                    </label>
                    <input
                            id    = "text_color"
                            type  = "color"
                            name  = "text_color"
                            value = "<?php echo esc_attr( $text_color ); ?>"/>
                </p>

                <p class="options-row">
                    <input
                            class = "button-primary"
                            type  = "submit"
                            name  = "save_breaking_news"
                            value = "Submit"/>
                </p>
            </form>
        </div>



    </div>

    <div class="bnews-admin-section">
        <div class="section-header">
            <h3>Current Breaking Post</h3>
        </div>
        <div class="section-content">
	        <?php
	        $breaking_news_posts = get_posts( array(
		        'post_type'     => 'post',
		        'post_status'   => 'published',
		        'meta_key'      => 'is_breaking_news',
		        'meta_value'    => 'on'
	        ) );
	        $latest_breaking_news = isset( $breaking_news_posts ) ? $breaking_news_posts[0] : null;
	        if ( empty( $latest_breaking_news ) ) {
		        echo __( 'No post has been setup as breaking news yet.', $this->text_domain );
	        } else {
		        $post_id = $latest_breaking_news->ID;
		        echo '<h4>' . $latest_breaking_news->post_title . '</h4>';
		        echo '<a href = "' . get_edit_post_link( $post_id ) . '">' . __( 'Edit the Post', $this->text_domain ) . '</a>';
	        }
	        ?>
        </div>


    </div>
</div>