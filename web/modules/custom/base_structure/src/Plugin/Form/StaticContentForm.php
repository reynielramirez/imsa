<?php

namespace Drupal\base_structure\Plugin\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\Query\QueryInterface;
use Drupal\base_structure\Service\BaseStructureService;

class StaticContentForm extends FormBase
{
    protected $service;

    public function __construct(BaseStructureService $service)
    {
        $this->service = $service;
    }

    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('base_structure_service')
        );
    }

    public function getFormId()
    {
        return 'static-content-form';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {

        // General --------------------------------------------------

        $this->service->addGroup($form,'general','General');
        $this->service->addImage($form,'general','site_logo','Site logo');
        $this->service->addRichTextarea($form,'general','methodology','Methodology');

        $this->service->addTextfield($form,'general','site_title_section','Site title section');
        $this->service->addImage($form,'general','site_image_section','Site image section');
        $this->service->addRichTextarea($form, 'general', 'site_text_section', 'Site text section');

        // Social networks ---------------------------------------------

        $this->service->addGroup($form, 'social_networks', 'Social Networks');
        $this->service->addLink($form, 'social_networks', 'facebook', 'Facebook');
        $this->service->addLink($form, 'social_networks', 'twitter', 'X');
        $this->service->addLink($form, 'social_networks', 'instagram', 'Instagram');
        $this->service->addLink($form, 'social_networks', 'linkedin', 'Linkedin');
        $this->service->addLink($form, 'social_networks', 'youtube', 'Youtube');
        $this->service->addLink($form, 'social_networks', 'vimeo', 'Vimeo');
        $this->service->addLink($form, 'social_networks', 'telegram', 'Telegram');
        $this->service->addLink($form, 'social_networks', 'whatsapp', 'whatsapp');

        // About Us ---------------------------------------------

        $this->service->addGroup($form, 'about_us', 'About Us');
        $this->service->addImage($form, 'about_us', 'about_banner', 'Banner image');
        $this->service->addTextarea($form,'about_us','about_text','Text banner');
        $this->service->addTextarea($form, 'about_us', 'about_description', 'Description');
        $this->service->addTextarea($form, 'about_us', 'mission', 'Mission');
        $this->service->addImage($form, 'about_us', 'mission_img', 'Image');
        $this->service->addTextarea($form, 'about_us', 'vision', 'Vision');
        $this->service->addImage($form, 'about_us', 'vision_img', 'Image');
        $this->service->addTextarea($form, 'about_us', 'purpose', 'Purpose');
        $this->service->addImage($form, 'about_us', 'purpose_img', 'Image');

        // Products and services ---------------------------------------------

        $this->service->addGroup($form, 'products_services', 'Products and services');
        $this->service->addImage($form, 'products_services', 'products_banner', 'Products banner image');
        $this->service->addTextarea($form,'products_services','products_text','Text banner');
        $this->service->addImage($form, 'products_services', 'services_banner', 'Services banner image');
        $this->service->addTextarea($form,'products_services','services_text','Text banner');

        // Blog ---------------------------------------------

        $this->service->addGroup($form, 'news', 'Blog');
        $this->service->addImage($form, 'news', 'news_banner', 'Banner image');
        $this->service->addTextarea($form,'news','news_text','Text banner');


        // FAQ ---------------------------------------------

        $this->service->addGroup($form, 'faq', 'FAQ');
        $this->service->addImage($form, 'faq', 'faq_banner', 'Banner image');
        $this->service->addTextarea($form,'faq','faq_text','Text banner');


        // Contact Us ---------------------------------------------

        $this->service->addGroup($form, 'contact_us', 'Contact');
        $this->service->addImage($form, 'contact_us', 'contact_banner', 'Banner image');
        $this->service->addTextarea($form, 'contact_us', 'contact_text', 'Text banner');
        $this->service->addImage($form, 'contact_us', 'logo', 'Logo');
        $this->service->addAddress($form, 'contact_us', 'address', 'Address');
        $this->service->addPhone($form, 'contact_us', 'phone', 'Phone');
        $this->service->addEmail($form, 'contact_us', 'email', 'Email');
        $this->service->addImage($form,'contact_us','reference_one_img','Image reference 1');
        $this->service->addImage($form,'contact_us','reference_two_img','Image reference 2');

        $form['save'] = [
            '#type' => 'submit',
            '#value' => t('Save'),
        ];

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $this->saveConfig($form_state->getValues());
        \Drupal::service('messenger')->addMessage(t('The information has been successfully updated'));
    }

    public function saveConfig(array &$data)
    {

        // General --------------------------------------------------

        $this->service->saveImage('site_logo', $data);
        $this->service->saveText('methodology', $data);
        $this->service->saveImage('site_image_section', $data);
        $this->service->saveText('site_text_section', $data);
        $this->service->saveText('site_title_section', $data);

        // Social networks ---------------------------------------------

        $this->service->saveText('facebook', $data);
        $this->service->saveText('twitter', $data);
        $this->service->saveText('instagram', $data);
        $this->service->saveText('linkedin', $data);
        $this->service->saveText('youtube', $data);
        $this->service->saveText('vimeo', $data);
        $this->service->saveText('telegram', $data);
        $this->service->saveText('whatsapp', $data);

        // About Us ---------------------------------------------

        $this->service->saveImage('about_banner', $data);
        $this->service->saveText('about_text', $data);
        $this->service->saveText('about_description', $data);
        $this->service->saveText('mission', $data);
        $this->service->saveImage('mission_img', $data);
        $this->service->saveText('vision', $data);
        $this->service->saveImage('vision_img', $data);
        $this->service->saveText('purpose', $data);
        $this->service->saveImage('purpose_img', $data);

        // Products and services ---------------------------------------------

        $this->service->saveImage('products_banner', $data);
        $this->service->saveImage('services_banner', $data);

        $this->service->saveText('products_text', $data);
        $this->service->saveText('services_text', $data);
        

        // Blog ---------------------------------------------

        $this->service->saveImage('news_banner', $data);
        $this->service->saveText('news_text', $data);

        // FAQ ---------------------------------------------

        $this->service->saveImage('faq_banner', $data);
        $this->service->saveText('faq_text', $data);

        // Contact Us ---------------------------------------------

        $this->service->saveImage('contact_banner', $data);
        $this->service->saveText('contact_text', $data);
        $this->service->saveImage('logo', $data);
        $this->service->saveText('address', $data);
        $this->service->saveText('phone', $data);
        $this->service->saveText('email', $data);
        $this->service->saveImage('reference_one_img', $data);
        $this->service->saveImage('reference_two_img', $data);

        $this->service->saveConfig();
    }
}
