<?php

namespace Drupal\blog\Form;

use Drupal\Core\Datetime\TimeZoneFormHelper;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Password\PhpPassword;
use Drupal\user\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Display and handle User Register Form.
 */
class RegisterForm extends Formbase {

  /**
   * PhpPassword.
   *
   * @var \Drupal\Core\Password\PhpPassword
   */
  protected $phpPassword;

  /**
   * {@inheritdoc}
   */
  public function __construct(PhpPassword $php_password) {
    $this->phpPassword = $php_password;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return $container->get('blog.register');
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['blog.timezone_config', 'blog.language_config'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'user_register_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm($form, FormStateInterface $form_state, int $id = NULL) {

    $timezone_config = $this->config('blog.timezone_config');
    $language_config = $this->config('blog.language_config');

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
      '#maxlength' => 60,
      '#minlength' => 10,
      '#description' => $this->t('The email address is not made public. It will only be used if you need to be contacted about your account or for opted-in notifications.'),
    ];

    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#required' => TRUE,
      '#maxlength' => 60,
      '#minlength' => 5,
      '#description' => $this->t("Several special characters are allowed, including space, period (.), hyphen (-), apostrophe ('), underscore (_), and the @ sign."),
    ];

    $form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Password'),
      '#required' => TRUE,
      '#maxlength' => 60,
      '#minlength' => 5,
      '#description' => $this->t('Provide a password for the new account in both fields.'),
    ];

    $form['password_confirm'] = [
      '#type' => 'password',
      '#title' => $this->t('Password Confirm'),
      '#required' => TRUE,
      '#maxlength' => 60,
      '#minlength' => 5,
    ];

    $form['image'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Picture'),
      '#multiple' => FALSE,
      '#upload_location' => 'public://images/',
      '#upload_validators' => [
        'file_validate_extensions' => ['png gif jpg jpeg'],
        'file_validate_size' => [100 * 1024 * 1024],
      ],
      '#description' => $this->t('One file only. <br> 100 MB limit. <br> Allowed types: png, gif, jpg, jpeg.'),
    ];

    $form['language'] = [
      '#type' => 'language_select',
      '#title' => $this->t('Language'),
      '#default_value' => $language_config->get('language') ?: 'en',
      '#description' => $this->t("This account's preferred language for emails and site presentation. This is also assumed to be the primary language of this account's profile information."),
    ];

    $form['timezone'] = [
      '#type' => 'select',
      '#title' => $this->t('Timezone'),
      '#default_value' => $timezone_config->get('timezone') ?: 'UTC',
      '#options' => TimeZoneFormHelper::getOptionsList(),
      '#description' => $this->t('Select the desired local time and time zone. Dates and times throughout this site will be displayed using this time zone.'),
    ];

    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
      ],
    ];

    if (isset($id)) {
      $form['title'] = "User Edit";
      $form['uid'] = $id;
      $user = User::load($id);
      $form['email']['#default_value'] = $user->getEmail();
      $form['username']['#default_value'] = $user->get('name')->getValue()[0]['value'];
      $form['language']['#default_value'] = $user->get('langcode')->getValue()[0]['value'];
      $form['timezone']['#default_value'] = $user->get('timezone')->getValue()[0]['value'];
      $form['password']['#required'] = FALSE;
      $form['password_confirm']['#required'] = FALSE;
      if (isset($user->user_picture->entity)) {
        $fid = $user->user_picture->entity->fid->getValue()[0];
        $form['image']['#default_value'] = $fid;
      }
    }
    $form['#theme'] = 'account_register_form';
    $form['#attached']['library'][] = 'blog/form';
    return $form;
  }

  /**
   * Validate email duplication.
   */
  public function validateDuplication(
        string $form_field_name,
        array &$form,
        FormStateInterface $form_state,
    ) {
    if ($form_field_name === "email") {
      $email = $form_state->getValue('email');
      $query = \Drupal::entityQuery('user');
      $query->accessCheck(TRUE);
      $query->condition('mail', $email);
      $query->count();
      $existing_user = $query->execute();

      if ($existing_user) {
        $form_state->setErrorByName('email', $this->t('Email already exists.'));
      }
    }
    elseif ($form_field_name === "username") {
      $username = $form_state->getValue('username');
      $query = \Drupal::entityQuery('user');
      $query->accessCheck(TRUE);
      $query->condition('name', $username);
      $query->count();
      $existing_user = $query->execute();

      if ($existing_user) {
        $form_state->setErrorByName('username', $this->t('Username already exists.'));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {

    if (mb_strlen($form_state->getValue('email')) < 10) {
      $form_state->setErrorByName(
            'username',
            $this->t('Email should be at least 10 characters.'),
        );
    }

    if (mb_strlen($form_state->getValue('username')) < 5) {
      $form_state->setErrorByName(
            'username',
            $this->t('Username should be at least 5 characters.'),
        );
    }

    if (isset($form['uid']) && is_numeric($form['uid'])) {
      $user = User::load($form['uid']);
      $user_email = $user->getEmail();
      $form_email = $form_state->getValue('email');
      if ($user_email !== $form_email) {
        $this->validateDuplication("email", $form, $form_state);
      }

      $user_name = $user->getAccountName();
      $form_name = $form_state->getValue('username');
      if ($user_name !== $form_name) {
        $this->validateDuplication("username", $form, $form_state);
      }
    }

    if (!empty($form_state->getValue('password'))) {
      $password = $form_state->getValue('password');
      $password_confirm = $form_state->getValue('password_confirm');

      if ($password !== $password_confirm) {
        $form_state->setErrorByName('password_confirm', $this->t('The passwords do not match.'));
      }
      if (mb_strlen($form_state->getValue('password')) < 5) {
        $form_state->setErrorByName(
              'username',
              $this->t('Password should be at least 5 characters.'),
          );
      }
    }

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    if (isset($form['uid']) && is_numeric($form['uid'])) {
      $user = User::load($form['uid']);
      $user->setEmail($form_state->getValue('email'));
      $user->setUsername($form_state->getValue('username'));
      if (!empty($form_state->getValue('password'))) {
        $user->setPassword($this->phpPassword->hash($form_state->getValue('password')));
      }
      $user->set('timezone', $form_state->getValue('timezone'));
      $user->set('langcode', $form_state->getValue('language'));
      if (!empty(($form_state->getValue('image')))) {
        $image_file = $form_state->getValue('image');
        $user->set('user_picture', $image_file);
      }
      $this->messenger()->addStatus($this->t('Edited User Information.'));
      $user->save();
    }
    else {
      $new_user = User::create(
            [
              'mail' => $form_state->getValue('email'),
              'name' => $form_state->getValue('username'),
              'pass' => $this->phpPassword->hash($form_state->getValue('password')),
              'timezone' => $form_state->getValue('timezone'),
              'langcode' => $form_state->getValue('language'),
            ]
            );
      if (!empty(($form_state->getValue('image')))) {
        $image_file = $form_state->getValue('image');
        $new_user->set('user_picture', $image_file);
      }
      $new_user->save();
      $this->messenger()->addStatus($this->t('Registration successful.'));
    }
    $form_state->setRedirect('<front>');
  }

}
