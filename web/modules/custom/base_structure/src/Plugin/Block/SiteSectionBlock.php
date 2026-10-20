<?php

namespace Drupal\base_structure\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\base_structure\Service\BaseStructureService;
use Drupal;
use Drupal\file\Entity\File;
use Drupal\block\Entity\Block;

/**
 * @Block(
 * 	 id = "site_section_block",
 * 	 admin_label = @Translation("Bloque para seccion del sitio")
 * )
 */

class SiteSectionBlock extends BlockBase {

    public function build(){

		$data = [];

		$service = Drupal::getContainer()->get('base_structure_service');

        $data["image"] = $service->getConfigURL("site_image_section");
		$data["text"] =  $service->getConfigText("site_text_section");
		$data["title"] = $service->getConfigText("site_title_section");

		$library['library'][] = 'base_structure/site-section-styling';

		return [
			'#theme' => 'site_section_block',
			'#data' => $data,
			'#titulo' => $this->t('Site Section Block'),
			'#attached' => $library,
			'#cache' => [
				'max-age' => 0,
			],
		];
	}
}
