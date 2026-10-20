<?php

namespace Drupal\base_structure\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Drupal;

/**
 * @Block(
 *   id = "services_block",
 *   admin_label = @Translation("Bloque para los Servicios")
 * )
 */
 
class ServicesBlock extends BlockBase {

	public function build() {
		
		$data = array();
        $language = Drupal::languageManager()->getCurrentLanguage()->getId();

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
			->accessCheck(FALSE);

		if ($subservicios) {
			$query->condition('nid', $subservicios, 'NOT IN');
		}

		$node_ids = $query->execute();
        
		if(!empty($node_ids)){
            $nodes = Node::loadMultiple($node_ids);
            foreach ($nodes as $node){
                $data[] = $node->getTranslation($language);
            }
        }
		
		$library['library'][] = 'base_structure/products-services-styling';

		return [
			'#theme' => 'services_block',
			'#data' => $data,
			'#titulo' => $this->t('Services Block'),
			'#attached' => $library,
			'#cache' => [
				'max-age' => 0, 
				'tags' => ['node_list'], 
				'contexts' => ['url.path'], 
			],
		];
	}
}