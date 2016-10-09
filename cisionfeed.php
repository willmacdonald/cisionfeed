<?php

/*
Plugin Name: Cisionfeed
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.0
Author: wilmac
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/


add_shortcode( 'displayfeed', 'get_feed' );

function cision_styles() {

    wp_enqueue_style( 'cision_styles', plugins_url( '/cisionfeed.css', __FILE__ )  );

}

add_action( 'wp_enqueue_scripts', 'cision_styles' );


function get_feed () {
	$UniqueIdentifier = '1A9B3BA21AD74A7990F9EFBCCC6EBD68';

	$json = file_get_contents('http://publish.ne.cision.com/papi/NewsFeed/' . $UniqueIdentifier . '?format=json');

	$data = json_decode($json,true);


	echo '<section class="cision-feed-wrapper">';
	foreach ($data['Releases'] as $item) {
		if (is_array($item)) {
			echo '<article class="cision-feed-item" style="padding: 12px 0">';
			echo '<header class="cision-feed-title"><h2>';
			echo esc_html($item['Title']);
			echo '</h2></header>';

			echo '<time class="cision-feed-item-publish tooltip" datetime="'.esc_html($item['PublishDate']).'">';
			echo esc_html(substr($item['PublishDate'],0,strpos($item['PublishDate'],'T')));
			echo '</time>';

			echo '<p class="cision-feed-intro">' . esc_html($item['Intro']) .'</p>';
            echo '<a class="cision-feed-link" href="' . esc_html($item['CisionWireUrl']) .'" title="'.esc_html($item['Title']).'">Läs mer</a>';
			echo '</article>';
		}
	}
	echo '</section>';
}

