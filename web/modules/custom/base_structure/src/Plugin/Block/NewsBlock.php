<?php

namespace Drupal\base_structure\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Drupal;

/**
 * @Block(
 *   id = "news_block",
 *   admin_label = @Translation("Bloque para las Noticias")
 * )
 */
 
class NewsBlock extends BlockBase {

	public function build() {
		
		$data = array();
        $language = Drupal::languageManager()->getCurrentLanguage()->getId();
        
		$node_ids = Drupal::entityQuery('node')
            ->condition('type','news')
            ->condition('langcode',$language)
            ->condition('status', 1)
            ->accessCheck(FALSE)
			->sort("field_date","DESC")
			->pager(3)
            ->execute();

		if(!empty($node_ids)){
            $nodes = Node::loadMultiple($node_ids);
            foreach ($nodes as $node){
                $data[] = $node->getTranslation($language);
            }
        }
		
		$library['library'][] = 'base_structure/news-styling';

		return [
			'#theme' => 'news_block',
			'#data' => $data,
			'#titulo' => $this->t('News Block'),
			'#attached' => $library,
			'#cache' => [
				'max-age' => 0, 
				'tags' => ['node_list'], 
				'contexts' => ['url.path'], 
			],
		];
	}
}