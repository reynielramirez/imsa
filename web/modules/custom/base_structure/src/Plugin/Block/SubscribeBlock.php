<?php

namespace Drupal\base_structure\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @Block(
 *   id = "subscribe_block",
 *   admin_label = @Translation("Bloque para las subscripciones")
 * )
 */
class SubscribeBlock extends BlockBase implements ContainerFactoryPluginInterface {

    /**
     * The form builder.
     *
     * @var \Drupal\Core\Form\FormBuilderInterface
     */
    protected $formBuilder;

    /**
     * Constructs a new SubscribeBlock.
     *
     * @param array $configuration
     *   A configuration array containing information about the plugin instance.
     * @param string $plugin_id
     *   The plugin_id for the plugin instance.
     * @param mixed $plugin_definition
     *   The plugin implementation definition.
     * @param \Drupal\Core\Form\FormBuilderInterface $form_builder
     *   The form builder.
     */
    public function __construct(array $configuration, $plugin_id, $plugin_definition, FormBuilderInterface $form_builder) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->formBuilder = $form_builder;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static(
        $configuration,
        $plugin_id,
        $plugin_definition,
        $container->get('form_builder')
        );
    }

    public function build(){

		//$block = Block::load('subscribe-form'); //Block Name in Block Design
		
		//$data["form"] = \Drupal::entityTypeManager()
		//	->getViewBuilder('block')
		//	->view($block);	

		$data["form"] = $this->formBuilder->getForm('\Drupal\base_structure\Plugin\Form\SubscribeForm');

        $library['library'][] = 'base_structure/subscribe-styling';

		return [
            '#theme' => 'subscribe_block',
            '#titulo' => $this->t('Subscribe Block'),
            '#data' => $data,
			'#attached' => $library,
            '#cache' => [
                'max-age' => 0,
            ],
        ];
    }
}
