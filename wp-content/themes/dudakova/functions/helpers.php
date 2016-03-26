<?php
/**
 * Checks if the variable is set and not empty and if so returns it
 *
 * @param $variable
 * @param $before
 * @param $after
 * @return string|void
 */
function checkAndReturn( $variable, $before = '', $after = '' ) {

    if( ! isset($variable) || empty($variable) ) {
        return;
    }

    $output = $before . $variable . $after;

    return $output;
}

/**
 * Checks if the variable is set and not empty and if so echoes it
 *
 * @param $variable
 * @param $before
 * @param $after
 */
function checkAndEcho( $variable, $before = '', $after = '' ) {

    if( ! isset($variable) || empty($variable) ) {
        return;
    }

    $output = $before . $variable . $after;

    echo $output;
}

/**
 * Builds and echoes a button if it's text is set
 *
 * @param $buttonLink
 * @param $buttonText
 * @param $class
 */
function echoButton( $buttonLink = '#', $buttonText, $class = '' ) {

    if( ! isset($buttonText) || empty($buttonText) ) {
        return;
    }

    $output = '<a href="';
    $output .= $buttonLink;
    $output .= '" type="button" class="';
    $output .= $class;
    $output .= '">';
    $output .= $buttonText;
    $output .= '</a>';

    echo $output;
}