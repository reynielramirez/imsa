<?php

namespace Drupal\base_structure\Plugin\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\Query\QueryInterface;
use Drupal\base_structure\Service\BaseStructureService;
use Drupal\Core\Url;
use Drupal\contact\Entity\ContactForm;

class FeedbackForm extends FormBase {
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
        return 'feedback-form';
    }

public function buildForm(array $form, FormStateInterface $form_state) {
    
    $form['#attributes'] = [
      'class' => ['feedback-form', 'custom-form'],
    ];
    
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Su nombre'),
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Dirección de correo eléctronico'),
      '#required' => TRUE, 
    ];

    $form['demo'] = [
      '#type' => 'select',
      '#title' => $this->t('Solicitar demo'),
      '#options' => $this->getTaxonomyOptions(),
      '#empty_option' => $this->t('- None -'),
      '#required' => FALSE,
    ];

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#required' => TRUE,
      '#rows' => 5,
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send Message'),
      '#button_type' => 'primary',
    ];

    // Opcional: botón de reset
    $form['actions']['reset'] = [
      '#type' => 'button',
      '#value' => $this->t('Clear'),
      '#attributes' => [
        'onclick' => 'this.form.reset(); return false;',
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  private function getTaxonomyOptions() {
    $options = [];
    
    try {
        $terms = \Drupal::entityTypeManager()
            ->getStorage('taxonomy_term')
            ->loadTree('demos');
        
        foreach ($terms as $term) {
            $options[$term->tid] = $term->name;
        }
    }
    catch (\Exception $e) {
        \Drupal::logger('base_structure')->error('Error loading taxonomy terms: @error', [
            '@error' => $e->getMessage(),
        ]);
    }
    
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');
    
    if (!\Drupal::service('email.validator')->isValid($email)) {
      $form_state->setErrorByName('email', $this->t('Por favor, escriba una dirección de correo válida.'));
    }

    $message = $form_state->getValue('message');
    if (strlen($message) < 10) {
      $form_state->setErrorByName('message', $this->t('El mensaje debe tener al menos 10 caracteres.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Obtener los valores del formulario
    $values = $form_state->getValues();

    $name = $values['name'];
    $email = $values['email'];
    $demo = $form['demo']['#options'][$values['demo']] ?? 'Ninguno';
    $message = $values['message'];

    try{
      // Opcional: enviar email de notificación
      $this->sendNotificationEmail($name, $email, $demo, $message);

      // Redireccionar después del envío
//      $form_state->setRedirectUrl(Url::fromRoute('<front>'));

      // Mensaje de confirmación
 //     $this->messenger()->addStatus($this->t('Thank you @name! Your feedback has been received.', [
	$this->messenger()->addStatus($this->t('Gracias @name! Su mensaje ha sido enviado.', [
        '@name' => $name,
      ]));

    } catch (\Exception $e) {
      // Manejar errores
      \Drupal::logger('base_structure')->error('Error at send feedback: @error', [
        '@error' => $e->getMessage(),
      ]);
      
//      $this->messenger()->addError($this->t('There was an error submitting your feedback. Please try again.'));
	$this->messenger()->addError($this->t('Ocurrió un error enviando su mensaje. Por favor inténtelo nuevamente.'));
    }
  }

    /**
    * Envía un email de notificación.
    */
    private function sendNotificationEmail($name, $email, $demo, $message) {
	  
        // Obtener el destinatario desde la configuración del formulario de contacto
        $contact_form = ContactForm::load('feedback_form');
        $recipients = $contact_form ? $contact_form->getRecipients() : [];
	$site_name = \Drupal::config('system.site')->get('name');
        $mail_manager = \Drupal::service('plugin.manager.mail');
        $module = 'base_structure';
        $key = 'feedback_form';
        $to = $recipients[0];
        $reply = $email;
        $params = [
            'name' => $name,
            'email' => $email,
            'demo' => $demo,
            'message' => $message,
	    'subject' => $site_name . ": Formulario de contacto del sitio web",

        ];
        $langcode = \Drupal::currentUser()->getPreferredLangcode();
        $send = true;

        $result = $mail_manager->mail($module, $key, $to, $langcode, $params, $reply, $send);
    
        if ($result['result']) {
          \Drupal::logger('base_structure')->info('Notification email sent for feedback from @name', [
              '@name' => $name,
          ]);
        }
    }
    
}
