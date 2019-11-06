<?php
$links_array = array(
	'a' => [ 'https://kingsoftheweb.ca/who-we-are/', 'Kings Of The Web for Web Services' ],
	'b' => [ 'https://kingsoftheweb.ca/website-design-near-me/website-design-in-brampton/', 'Web Design Company in Brampton' ],
	'c' => [ 'https://kingsoftheweb.ca/contact/', 'Contact Kings Of The Web' ],
	'd' => [ 'https://kingsoftheweb.ca/website-design-demos/', 'Website Design Demos' ],
	'e' => [ 'https://kingsoftheweb.ca/website-services/ecommerce-online-store/', 'Ecommerce Websites by Kings Of The Web' ],
	'f' =>  [ 'https://kingsoftheweb.ca/seo-services/best-seo-in-brampton/', 'Seo Brampton Services' ],
	'g' =>  [ 'https://kingsoftheweb.ca/website-design-near-me/web-design-guelph/', 'Guelph Web Design' ],
	'h' =>  [ 'https://kingsoftheweb.ca/website-design-near-me/web-design-in-hamilton/', 'Hamilton Web Design' ],
	'i' =>  [ 'https://kingsoftheweb.ca/seo-services/best-seo-in-mississauga/', 'Mississauga SEO Services' ],
	'j' =>  [ 'https://kingsoftheweb.ca/seo-services/best-seo-in-woodbridge/', 'SEO Services in Woodbridge' ],
	'k' =>  [ 'https://kingsoftheweb.ca/seo-services/best-seo-in-toronto/', 'SEO Services in Toronto' ],
	'l' =>  [ 'https://kingsoftheweb.ca/seo-services/best-seo-in-vaughan', 'SEO Services in Vaughan' ],
	'm' => [ 'https://kingsoftheweb.ca/website-design-near-me/web-design-in-mississauga/', 'Web Design in Mississauga' ],
	'n' => [ 'https://kingsoftheweb.ca/website-design-near-me/website-design-in-newmarket/', 'Web Design in Newmarket' ],
	'o' => [ 'https://kingsoftheweb.ca/website-design-near-me/web-design-in-oakville/', 'Web Design Company in Oakville' ],
	'p' =>  [ 'https://kingsoftheweb.ca/website-design-near-me/website-design-in-markham/', 'Web Design in Markham' ],
	'q' =>  [ 'https://kingsoftheweb.ca/seo-services/best-seo-in-oakville/', 'Oakville SEO Services' ],
	'r' => [ 'https://kingsoftheweb.ca/website-design-near-me/web-design-in-richmondhill/', 'Richmondhill Website Services' ],
	's' =>  [ 'https://kingsoftheweb.ca/website-services/logo-design-branding/', 'Logo Design and Branding' ],
	't' => [ 'https://kingsoftheweb.ca/website-design-near-me/website-design-in-toronto/', 'Web Design Company in Toronto' ],
	'u' =>  [ 'https://kingsoftheweb.ca/what-is-website-speed-optimization/', 'Website Speed Optimization Services' ],
	'v' => [ 'https://kingsoftheweb.ca/website-design-near-me/website-design-in-vaughan/', 'Website Design in Vaughan' ],
	'w' => [ 'https://kingsoftheweb.ca/website-design-near-me/website-design-woodbridge/', 'Website Design in Woodbridge' ],
	'x' =>  [ 'http://kingsoftheweb.ca/', 'Developed by Kings Of The Web' ],
	'y' =>  [ 'http://kingsoftheweb.ca/', 'Developed by Kings Of The Web' ],
	'z' =>  [ 'http://kingsoftheweb.ca/', 'Web Design by Kings Of The Web' ],
	'0' => [ 'http://kingsoftheweb.ca/', 'Developed by Kings Of The Web' ],

);
global $post;
$post_title   = isset( $post ) ? $post->post_title : '0';
$first_letter = strtolower($post_title[0]);

if (!preg_match("/^[a-z]$/", $first_letter)) {
	$first_letter = 0;
}

$copyright_anchor = $links_array[$first_letter][1];
$copyright_link = $links_array[$first_letter][0];

$copyright = '<a href = "' . $copyright_link . '">' . $copyright_anchor . ' </a>';
?>

<div id = "kotw-footer"><?php echo $copyright; ?></div>
<style>
	div#kotw-footer {
		display: flex;
		width: 100%;
		justify-content: center;
		align-items: center;
	}
</style>