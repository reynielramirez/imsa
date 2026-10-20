<?php

namespace Drupal\base_structure\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Drupal;

/**
 * @Block(
 *   id = "banner_block",
 *   admin_label = @Translation("Bloque para el Carrusel")
 * )
 */
 
class BannerBlock extends BlockBase {

	public function build() {
		
		$data = array();
        $language = Drupal::languageManager()->getCurrentLanguage()->getId();

		// Obtener el eslogan y nombre del sitio desde la configuración del sitio
		$site_config = Drupal::config('system.site');
		$slogan = $site_config->get('slogan');
		$site_name = $site_config->get('name');

		$service = Drupal::getContainer()->get('base_structure_service');
		$site_logo = $service->getConfigURL("site_logo");
    
		$node_ids = Drupal::entityQuery('node')
            ->condition('type','banner')
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
		
		$library['library'][] = 'base_structure/banner-styling';

		return [
			'#theme' => 'banner_block',
			'#data' => $data,
			'#slogan' => $slogan,
			'#site_name' => $site_name,
			'#site_logo' => $site_logo,
			'#titulo' => $this->t('Banner Block'),
			'#attached' => $library,
			'#cache' => [
				'max-age' => 0, 
				'tags' => ['node_list'], 
				'contexts' => ['url.path'], 
			],
		];
	}
}