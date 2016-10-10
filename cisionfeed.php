<?php

/**
Plugin Name: Cisionfeed
Description: Displays JSON feed from Cision
Version: 1.0
Author: William Macdonald
Author URI: http://macscan.net
License: GPL2
*/


add_shortcode( 'displayfeed', 'get_feed' );

function cision_styles() {

    wp_enqueue_style( 'cision_styles', plugins_url( '/cisionfeed.css', __FILE__ )  );

}

//add_action( 'wp_enqueue_scripts', 'cision_styles' );


function get_feed () {


	$UniqueIdentifier = '1A9B3BA21AD74A7990F9EFBCCC6EBD68';

	$json = file_get_contents('http://publish.ne.cision.com/papi/NewsFeed/' . $UniqueIdentifier . '?format=json');

	$data = json_decode($json,true);


	$return = '<section class="cision-feed-wrapper">';
	
	foreach ($data['Releases'] as $item) {
		if (is_array($item)) {
			$return .= '<article class="cision-feed-item" style="padding: 12px 0">
						<header class="cision-feed-title"><h2>'
			. esc_html($item['Title']) .
			'</h2></header>
			<time class="cision-feed-item-publish tooltip" datetime="'
			. esc_html($item['PublishDate']).
			'">'
			. esc_html(substr($item['PublishDate'],0,strpos($item['PublishDate'],'T'))) .
			'</time>
			<p class="cision-feed-intro">' 
			. esc_html($item['Intro']) .
			'</p>
            <a class="cision-feed-link" href="' 
            . esc_html($item['CisionWireUrl']) .
            '" title="' 
            . esc_html($item['Title']).
            '">Läs mer</a>
			</article>';
		}
	}
	$return .= '</section>';
	
	return $return;
}

