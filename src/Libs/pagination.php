<?php

use Vortex\Config\Config;

function pagination( $totalResults, $path, $sign = '/' ) {

	$page       = isset( $_GET['page'] ) ? $_GET['page'] : 1;
	$maxResults = Config::get( 'max_results' );
	$mainUrl    = Config::get( 'urls', 'main_url' );


	echo '<ul class="pagination">';

	$totalPages = ceil( $totalResults / $maxResults );

	if ( $page > 1 ) {
		$prev = $page - 1;
		echo '<li class="page-item"><a class="page-link" href="' . $mainUrl . $path . 'page' . $sign . $prev . '">&laquo; Previous</a></li>';
	}


	if ( $page > 9 ) {
		for ( $i = 1; $i <= $totalPages; $i ++ ) {
			if ( $page == $i ) {
				echo '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
			} else {
				if ( $i == 1 ) {
					$pageNum = 1;
				} else {
					$pageNum = $i;
				}

				if ( $i < ( $page + 8 ) && $i > ( $page - 8 ) ) {
					echo '<li class="page-item"><a class="page-link" href="' . $mainUrl . $path . 'page' . $sign . $pageNum . '">' . $pageNum . '</a></li>';
				}
			}
		}
	} else {
		for ( $i = 1; $i <= $totalPages; $i ++ ) {
			if ( $page == $i ) {
				echo '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
			} else {
				if ( $i == 1 ) {
					$pageNum = 1;
				} else {
					$pageNum = $i;
				}

				if ( $i <= 15 ) {
					echo '<li class="page-item"><a class="page-link" href="' . $mainUrl . $path . 'page' . $sign . $pageNum . '">' . $pageNum . '</a></li>';
				}
			}
		}
	}

	if ( $page < $totalPages ) {
		$next = ( $page + 1 );
		echo '<li class="page-item"><a class="page-link" href="' . $mainUrl . $path . 'page' . $sign . $next . '">Next &raquo;</a></li>';
	}

	echo '</ul>';

}
