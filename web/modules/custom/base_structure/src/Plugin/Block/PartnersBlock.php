<?php

namespace Drupal\base_structure\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Drupal;

/**
 * @Block(
 *   id = "paterns_block",
 *   admin_label = @Translation("Bloque para los Socios")
 * )
 */
 
class PartnersBlock extends BlockBase {

	public function build() {
		
		$data = array();
        $language = Drupal::languageManager()->getCurrentLanguage()->getId();
        
		$node_ids = Drupal::entityQuery('node')
            ->condition('type','partners')
            ->condition('langcode',$language)
            ->condition('status', 1)
            ->accessCheck(FALSE)
            ->execute();

		if(!empty($node_ids)){
            $nodes = Node::loadMultiple($node_ids);
            foreach ($nodes as $node){
                $data[] = $node->getTranslation($language);
            }
        }
		
		$library['library'][] = 'base_structure/partners-styling';

		return [
			'#theme' => 'partners_block',
			'#data' => $data,
			'#titulo' => $this->t('Partners Block'),
			'#attached' => $library,
			'#cache' => [
				'max-age' => 0, 
				'tags' => ['node_list'], 
				'contexts' => ['url.path'], 
			],
		];
	}
}