<?php

namespace Drupal\base_structure\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\base_structure\Service\BaseStructureService;
use Drupal;
use Drupal\file\Entity\File;

/**
 * @Block(
 * 	 id = "logo_block",
 * 	 admin_label = @Translation("Bloque para el Logo")
 * )
 */
 
class LogoBlock extends BlockBase {

    public function build(){

		$service = Drupal::getContainer()->get('base_structure_service');

		$data["logo"] = $service->getConfigURL("site_logo");
		
		$library['library'][] = 'base_structure/logo-styling';
		
		return [
            '#theme' => 'logo_block',
            '#titulo' => $this->t('Logo Block'),
            '#data' => $data,
			'#attached' => $library,
            '#cache' => [
				'max-age' => 0, 
				'tags' => ['node_list'], 
				'contexts' => ['url.path'], 
			],
        ];
    }
}
