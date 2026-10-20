<?php

namespace Drupal\base_structure\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Drupal;

/**
 * @Block(
 *   id = "methodology_block",
 *   admin_label = @Translation("Bloque para la metodología")
 * )
 */
 
class MethodologyBlock extends BlockBase {

	public function build() {
		
		$data = array();
		$service = Drupal::getContainer()->get('base_structure_service');
		$data["description"] = $service->getConfigText("methodology");
		
		$library['library'][] = 'base_structure/methodology-styling';

		return [
			'#theme' => 'methodology_block',
			'#data' => $data,
			'#titulo' => $this->t('Methodology Block'),
			'#attached' => $library,
			'#cache' => [
				'max-age' => 0, 
				'tags' => ['node_list'], 
				'contexts' => ['url.path'], 
			],
		];
	}
}