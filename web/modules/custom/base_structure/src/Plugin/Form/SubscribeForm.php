<?php

namespace Drupal\base_structure\Plugin\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\Query\QueryInterface;
use Drupal\base_structure\Service\BaseStructureService;
use Drupal\Core\Url;
use Drupal\contact\Entity\ContactForm;

class SubscribeForm extends FormBase {
    protected $service;

    public function __construct(BaseStructureService $service) {
        $this->service = $service;
    }

    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('base_structure_service')
        );
    }

    public function getFormId() {
        return 'subscribe-form';
    }

public function buildForm(array $form, FormStateInterface $form_state) {
    
    $form['#attributes'] = [
      'class' => ['subscribe-form', 'custom-form'],
    ];
    
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email Address'),
      '#required' => TRUE,
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send Message'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');
    
    if (!\Drupal::service('email.validator')->isValid($email)) {
      $form_state->setErrorByName('email', $this->t('Please enter a valid email address.'));
    }

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Obtener los valores del formulario
    $values = $form_state->getValues();
    
    $email = $values['email'];

    try{
      // Opcional: enviar email de notificación
      $this->sendNotificationEmail($email);

      // Redireccionar después del envío
//      $form_state->setRedirectUrl(Url::fromRoute('<front>'));

      // Mensaje de confirmación
      $this->messenger()->addStatus($this->t('Thank you! Subscription accepted.'));

    } catch (\Exception $e) {
      // Manejar errores
      \Drupal::logger('base_structure')->error('Error at send Subscription: @error', [
        '@error' => $e->getMessage(),
      ]);
      
      $this->messenger()->addError($this->t('There was an error submitting your subscription. Please try again.'));
    }
  }

    /**
    * Envía un email de notificación.
    */
    private function sendNotificationEmail($email) {
	  
        $site_name = \Drupal::config('system.site')->get('name');

        $mail_manager = \Drupal::service('plugin.manager.mail');
        $module = 'base_structure';
        $key = 'subscribe_form';
        $to = $email;
        $reply = null;
        $params = [
          'headers' => [
            'From' => $site_name . ' <no-reply@multisoft.cu>',
          ]
        ];
        $langcode = \Drupal::currentUser()->getPreferredLangcode();
        $send = true;

        $result = $mail_manager->mail($module, $key, $to, $langcode, $params, $reply, $send);
    
        if ($result['result']) {
          \Drupal::logger('base_structure')->info('Notification email sent for subscribe from @email', [
              '@email' => $email,
          ]);
        }
    }
}
