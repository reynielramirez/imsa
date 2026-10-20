<?php

namespace Drupal\base_structure\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface; 
use Drupal\node\Entity\Node;
use Drupal\comment\Entity\Comment;
use Drupal\base_structure\Service\BaseStructureService;
use Drupal\contact\Entity\Message;
use Drupal\contact\Entity\ContactForm;
use Drupal\block\Entity\Block;
use Drupal;
use Drupal\Core\Url;

class BaseStructureController extends ControllerBase {
	/**
	 * The form builder.
	 *
	 * @var \Drupal\Core\Form\FormBuilderInterface
	 */
	protected $formBuilder;

	/**
	 * Constructs a new BaseStructureController.
	 *
	 * @param \Drupal\Core\Form\FormBuilderInterface $form_builder
	 *   The form builder.
	 */
	public function __construct(FormBuilderInterface $form_builder) {
		$this->formBuilder = $form_builder;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function create(ContainerInterface $container) {
		return new static(
		$container->get('form_builder')
		);
	}

	public function getHome() {

		return [
			'#titulo' => $this->t('Home View'),
			'#cache' => [
				'max-age' => 0,
			],
		];
	}

	public function getAbout() {

		$data["items"] = array();
		$service = Drupal::getContainer()->get('base_structure_service');
		$language = Drupal::languageManager()->getCurrentLanguage()->getId();

        $data["banner"] = $service->getConfigURL("about_banner");
		$data["description"] = $service->getConfigText("about_description");
		$data["mission"] = $service->getConfigText("mission");
		$data["mission_img"] = $service->getConfigURL("mission_img");
		$data["vision"] = $service->getConfigText("vision");
		$data["vision_img"] = $service->getConfigURL("vision_img");
		$data["purpose"] = $service->getConfigText("purpose");
		$data["purpose_img"] = $service->getConfigURL("purpose_img");
		$data["banner_text"] = $service->getConfigText("about_text");

		$node_ids = Drupal::entityQuery('node')
            ->condition('type','values')
            ->condition('langcode',$language)
            ->condition('status', 1)
            ->accessCheck(FALSE)
            ->execute();

		if(!empty($node_ids)){
            $nodes = Node::loadMultiple($node_ids);
            foreach ($nodes as $node){
                $data['items'][] = $node->getTranslation($language);
            }
        }

		$node_ids = Drupal::entityQuery('node')
            ->condition('type','colaboradores')
            ->condition('langcode',$language)
            ->condition('status', 1)
            ->accessCheck(FALSE)
            ->execute();

		if(!empty($node_ids)){
            $nodes = Node::loadMultiple($node_ids);
            foreach ($nodes as $node){
                $data['colaboradores'][] = $node->getTranslation($language);
            }
        }

		$library['library'][] = 'base_structure/about-styling';

		return [
			'#theme' => 'about_view',
			'#data' => $data,
			'#titulo' => $this->t('About View'),
			'#attached' => $library,
			'#cache' => [
				'max-age' => 0,
			],
		];
	}
	
	public function getProducts() {

		$data["items"] = array();
		$service = Drupal::getContainer()->get('base_structure_service');
		$language = Drupal::languageManager()->getCurrentLanguage()->getId();

        $data["banner"] = $service->getConfigURL("products_banner");
		$data["text"] = $service->getConfigText("products_text");

		$database = \Drupal::database();

		$subquery = $database->select('node__field_productos', 'f');
		$subquery->addField('f', 'field_productos_target_id');
		$subquery->distinct();
		$subquery->join('node_field_data', 'padre', 'f.entity_id = padre.nid');
		$subquery->join('node_field_data', 'hijo', 'f.field_productos_target_id = hijo.nid');
		$subquery->condition('padre.status', 1);
		$subquery->condition('padre.type', 'products');
		$subquery->condition('hijo.status', 1);
		$subquery->condition('hijo.type', 'products');

		$subproductos = $subquery->execute()->fetchCol();

		$query = \Drupal::entityQuery('node')
			->condition('type', 'products')
			->condition('status', 1)
			->accessCheck(FALSE)
			->addTag('pager')
			->pager(9);

		if ($subproductos) {
			$query->condition('nid', $subproductos, 'NOT IN');
		}

		$node_ids = $query->execute();

		if(!empty($node_ids)){
            $nodes = Node::loadMultiple($node_ids);
            foreach ($nodes as $node){
                $data['items'][] = $node->getTranslation($language);
            }
        }
		
		$library['library'][] = 'base_structure/products-services-styling';

		return [
			'#theme' => 'products_view',
			'#data' => $data,
			'#titulo' => $this->t('Products View'),
			'#attached' => $library,
			'#cache' => [
				'max-age' => 0,
			],
		];
	}

	public function getServices() {

		$data["items"] = array();
		$service = Drupal::getContainer()->get('base_structure_service');
		$language = Drupal::languageManager()->getCurrentLanguage()->getId();

        $data["banner"] = $service->getConfigURL("services_banner");
		$data["text"] = $service->getConfigText("services_text");

		$database = \Drupal::database();

		$subquery = $database->select('node__field_servicios', 'f');
		$subquery->addField('f', 'field_servicios_target_id');
		$subquery->distinct();
		$subquery->join('node_field_data', 'padre', 'f.entity_id = padre.nid');
		$subquery->join('node_field_data', 'hijo', 'f.field_servicios_target_id = hijo.nid');
		$subquery->condition('padre.status', 1);
		$subquery->condition('padre.type', 'services');
		$subquery->condition('hijo.status', 1);
		$subquery->condition('hijo.type', 'services');

		$subservicios = $subquery->execute()->fetchCol();

		$query = \Drupal::entityQuery('node')
			->condition('type', 'services')
			->condition('status', 1)
			->accessCheck(FALSE)
			->addTag('pager')
			->pager(9);

		if ($subservicios) {
			$query->condition('nid', $subservicios, 'NOT IN');
		}

		$node_ids = $query->execute();

		if(!empty($node_ids)){
            $nodes = Node::loadMultiple($node_ids);
            foreach ($nodes as $node){
                $data['items'][] = $node->getTranslation($language);
            }
        }
		
		$library['library'][] = 'base_structure/products-services-styling';

		return [
			'#theme' => 'services_view',
			'#data' => $data,
			'#titulo' => $this->t('Services View'),
			'#attached' => $library,
			'#cache' => [
				'max-age' => 0,
			],
		];
	}

	public function getNews() {

		$data["items"] = array();
		$service = Drupal::getContainer()->get('base_structure_service');
		$language = Drupal::languageManager()->getCurrentLanguage()->getId();

        $data["banner"] = $service->getConfigURL("news_banner");
		$data["text"] = $service->getConfigText("news_text");

		$node_ids = Drupal::entityQuery('node')
            ->condition('type','news')
            ->condition('langcode',$language)
            ->condition('status', 1)
			->condition('field_date', date('Y-m-d-h-i-s'), '<=')
			->sort("field_date","DESC")
            ->accessCheck(FALSE)
			->addTag('pager')
			->pager(6)
            ->execute();

		if(!empty($node_ids)){
            $nodes = Node::loadMultiple($node_ids);
            foreach ($nodes as $node){
                $data['items'][] = $node->getTranslation($language);
            }
        }
		
		$library['library'][] = 'base_structure/news-styling';

		$build['content'] = array(
			'#theme' => 'news_view',
			'#data' => $data,
			'#titulo' => $this->t('News View'),
			'#attached' => $library,
			'#cache' => [
				'max-age' => 0,
			],
		);

		$build['pager'] = array(
			'#type' => 'pager',
			'#weight' => 10,
		);

		return $build;
	}
	
	public function getFaq() {

		$data["items"] = array();
		$service = Drupal::getContainer()->get('base_structure_service');
		$language = Drupal::languageManager()->getCurrentLanguage()->getId();

        $data["banner"] = $service->getConfigURL("faq_banner");
		$data["text"] = $service->getConfigText("faq_text");

		$node_ids = Drupal::entityQuery('node')
            ->condition('type','faq')
            ->condition('langcode',$language)
            ->condition('status', 1)
            ->accessCheck(FALSE)
			->addTag('pager')
			->pager(10)
            ->execute();

		if(!empty($node_ids)){
            $nodes = Node::loadMultiple($node_ids);
            foreach ($nodes as $node){
                $data['items'][] = $node->getTranslation($language);
            }
        }
		
		$library['library'][] = 'base_structure/faq-styling';

		$build['content'] = array(
			'#theme' => 'faq_view',
			'#data' => $data,
			'#titulo' => $this->t('FAQ View'),
			'#attached' => $library,
			'#cache' => [
				'max-age' => 0,
			],
		);

		$build['pager'] = array(
			'#type' => 'pager',
			'#weight' => 10,
		);

		return $build;
	}
	
	public function getContact() {

		$service = Drupal::getContainer()->get('base_structure_service');

        $data["banner"] = $service->getConfigURL("contact_banner");
		$data["text"] = $service->getConfigText("contact_text");
		$data["reference_one"] = $service->getConfigURL("reference_one_img");
		$data["reference_two"] = $service->getConfigURL("reference_two_img");
		$data["logo"] = $service->getConfigURL("logo");
		$data["address"] = $service->getConfigText("address");
		$data["phone"] = $service->getConfigText("phone");
		$data["email"] = $service->getConfigText("email");

		    // Socials
    	$data["facebook"] = $service->getConfigText("facebook");
		$data["twitter"] = $service->getConfigText("twitter");
		$data["instagram"] = $service->getConfigText("instagram");
		$data["linkedin"] = $service->getConfigText("linkedin");
		$data["youtube"] = $service->getConfigText("youtube");
		$data["vimeo"] = $service->getConfigText("vimeo");
		$data["telegram"] = $service->getConfigText("telegram");
		$data["whatsapp"] = $service->getConfigText("whatsapp");

		//$block = Block::load('feedback-form'); //Block Name in Block Design
		
		//$data["form"] = \Drupal::entityTypeManager()
		//	->getViewBuilder('block')
		//	->view($block);	

		$data["form"] = $this->formBuilder->getForm('\Drupal\base_structure\Plugin\Form\FeedbackForm');

		if (!$data["form"]) {
			return ['#markup' => $this->t('Formulario no encontrado')];
		}

		$library['library'][] = 'base_structure/contact-styling';

		return [
			'#theme' => 'contact_view',
			'#data' => $data,
			'#titulo' => $this->t('Contact View'),
			'#attached' => $library,
			'#cache' => [
				'max-age' => 0,
			],
		];
	}

	public function getPage403(){
		
        $data['base_path'] = base_path();
		$library['library'][] = 'base_structure/error-styling'; 
		
        return [
            '#theme' => 'page_403_view',
            '#titulo' => 'Block Custom Title',
            '#descripcion' => 'Block Custom Description',
            '#data' => $data,
			'#attached'=> $library,
            '#cache' => [
                'max-age' => 0,
            ],
        ];
    }

	public function getPage404(){
		
        $data['base_path'] = base_path();
		$library['library'][] = 'base_structure/error-styling'; 
		
        return [
            '#theme' => 'page_404_view',
            '#titulo' => 'Block Custom Title',
            '#descripcion' => 'Block Custom Description',
            '#data' => $data,
			'#attached'=> $library,
            '#cache' => [
                'max-age' => 0,
            ],
        ];
    }

}