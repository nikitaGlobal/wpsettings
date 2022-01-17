<?php
declare(strict_types=1);

/**
 * Plugin Breakingnews settings page model.
 *
 * @package   Breakingnews
 * @author    Nikita Menshutin
 * @copyright Copyright © 2022, Toptal
 */

namespace NikitaBreakingnews\Model;

use NikitaBreakingnews\Controller\ValidateOptions as Validator;

class Settings {
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
        add_action( 'admin_init', [ $this, 'settings_init' ] );
    }

    /**
     * Adding menu item to the plugin options page.
     *
     * @return void
     */
    public function add_admin_menu():void {
        add_menu_page(
            BREAKINGNEWS__PLUGINNAME,
            BREAKINGNEWS__PLUGINNAME,
            'manage_options',
            BREAKINGNEWS__SLUG,
            [ 'NikitaBreakingnews\View\SettingsPage', 'options_page' ]
        );

    }

    /**
     * Register settings, sections and fields.
     *
     * @return void
     */
    public function settings_init():void {
        register_setting(
            BREAKINGNEWS__SLUG,
            BREAKINGNEWS__SLUG .
            'settings',
            [ 'sanitize_callback' => [ 'NikitaBreakingnews\Controller\ValidateOptions', 'validate' ] ]
        );
        foreach ( BREAKINGNEWS__PLUGINOPTIONS as $section ) {
            add_settings_section(
                BREAKINGNEWS__SLUG . $section['id'],
                $section['title'],
                [ 'NikitaBreakingnews\View\SettingsPage', 'section_callback' ],
                BREAKINGNEWS__SLUG
            );
            foreach ( $section['fields'] as $field ) {
                add_settings_field(
                    $field['id'],
                    $field['label'],
                    [ 'NikitaBreakingnews\View\SettingsPage', 'field_' . $field['type'] ],
                    BREAKINGNEWS__SLUG,
                    BREAKINGNEWS__SLUG . $section['id'],
                    $field['id']
                );
            }
        }
    }
}
