<?php declare(strict_types = 1);

/**
 * @file
 * Theme settings form for Lando Blog theme.
 */

use Drupal\Core\Form\FormState;

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function lando_blog_form_system_theme_settings_alter(array &$form, FormState $form_state): void {

  $form['lando_blog'] = [
    '#type' => 'details',
    '#title' => t('Lando Blog'),
    '#open' => TRUE,
  ];

  $form['lando_blog']['example'] = [
    '#type' => 'textfield',
    '#title' => t('Example'),
    '#default_value' => theme_get_setting('example'),
  ];

}
