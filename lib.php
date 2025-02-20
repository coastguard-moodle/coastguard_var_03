<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Theme functions.
 *
 * @package    theme_coastguard_var_03
 * @copyright  2016 Frédéric Massart - FMCorz.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Post process the CSS tree.
 *
 * @param string $tree The CSS tree.
 * @param theme_config $theme The theme config object.
 */
function theme_coastguard_var_03_css_tree_post_processor($tree, $theme) {
    error_log('theme_coastguard_var_03_css_tree_post_processor() is deprecated. Required' .
        'prefixes for Bootstrap are now in theme/boost/scss/moodle/prefixes.scss');
    $prefixer = new theme_coastguard_var_03\autoprefixer($tree);
    $prefixer->prefix();
}

/**
 * Inject additional SCSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_coastguard_var_03_get_extra_scss($theme) {
    $content = '';
    $imageurl = $theme->setting_file_url('backgroundimage', 'backgroundimage');

    // Sets the background image, and its settings.
    if (!empty($imageurl)) {
        $content .= '@media (min-width: 768px) {';
        $content .= 'body { ';
        $content .= "background-image: url('$imageurl'); background-size: cover;";
        $content .= ' } }';
    }

    // Sets the login background image.
    $loginbackgroundimageurl = $theme->setting_file_url('loginbackgroundimage', 'loginbackgroundimage');
    if (!empty($loginbackgroundimageurl)) {
        $content .= 'body.pagelayout-login #page { ';
        $content .= "background-image: url('$loginbackgroundimageurl'); background-size: cover;";
        $content .= ' }';
    }

    // Always return the background image with the scss when we have it.
    return !empty($theme->settings->scss) ? $theme->settings->scss . ' ' . $content : $content;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_coastguard_var_03_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    if ($context->contextlevel == CONTEXT_SYSTEM && ($filearea === 'logo' || $filearea === 'backgroundimage' ||
        $filearea === 'loginbackgroundimage')) {
        $theme = theme_config::load('coastguard_var_03');
        // By default, theme files must be cache-able by both browsers and proxies.
        if (!array_key_exists('cacheability', $options)) {
            $options['cacheability'] = 'public';
        }
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    } else {
        send_file_not_found();
    }
}

/**
 * Returns the main SCSS content.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_coastguard_var_03_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : null;
    $fs = get_file_storage();

    $context = context_system::instance();
    
    /*####################################################################
    ##########      PATHS TO ADDITIONAL SCSS PRESETS -MH      ############
    ######################################################################
    ##########      REMEMBER TO UPDATE PATHS TO SCSS FILES    ############
    ######################################################################*/
    
    if ($filename == 'default.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/coastguard_var_03/scss/preset/default.scss');
    } else if ($filename == 'unitec_std.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/coastguard_var_03/scss/preset/unitec_std.scss');
    } else if ($filename == 'var_00.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/coastguard_var_03/scss/preset/var_00.scss');
    } else if ($filename == 'var_01.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/coastguard_var_03/scss/preset/var_01.scss');
    } else if ($filename == 'var_02.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/coastguard_var_03/scss/preset/var_02.scss');
    } else if ($filename == 'var_03.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/coastguard_var_03/scss/preset/var_03.scss');
    } else if ($filename == 'police.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/coastguard_var_03/scss/preset/police.scss');
    } else if ($filename == 'hawkins.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/coastguard_var_03/scss/preset/hawkins.scss');
    } else if ($filename == 'swift.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/coastguard_var_03/scss/preset/swift.scss');
    } else if ($filename == 'plain.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/coastguard_var_03/scss/preset/plain.scss');
    } else if ($filename && ($presetfile = $fs->get_file($context->id, 'theme_coastguard_var_03', 'preset', 0, '/', $filename))) {
        $scss .= $presetfile->get_content();
    } else {
        // Safety fallback - maybe new installs etc.
        $scss .= file_get_contents($CFG->dirroot . '/theme/coastguard_var_03/scss/preset/default.scss');
    }

    return $scss;
}

    /*####################################################################
    ##########   END PATHS TO ADDITIONAL SCSS PRESETS -MH     ############
    ######################################################################*/

/**
 * Get compiled css.
 *
 * @return string compiled css
 */

    /*#####################################################################
    ##########      REMEMBER TO UPDATE PATHS TO CSS FILES    ##############
    ######################################################################*/

function theme_coastguard_var_03_get_precompiled_css() {
    global $CFG;
    return file_get_contents($CFG->dirroot . '/theme/coastguard_var_03/style/moodle.css');
}

/**
 * Get SCSS to prepend.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_coastguard_var_03_get_pre_scss($theme) {
    global $CFG;

    $scss = '';
    $configurable = [
        // Config key => [variableName, ...].
        'brandcolor' => ['primary'],
    ];

    // Prepend variables first.
    foreach ($configurable as $configkey => $targets) {
        $value = isset($theme->settings->{$configkey}) ? $theme->settings->{$configkey} : null;
        if (empty($value)) {
            continue;
        }
        array_map(function($target) use (&$scss, $value) {
            $scss .= '$' . $target . ': ' . $value . ";\n";
        }, (array) $targets);
    }

    // Prepend pre-scss.
    if (!empty($theme->settings->scsspre)) {
        $scss .= $theme->settings->scsspre;
    }

    return $scss;
}
