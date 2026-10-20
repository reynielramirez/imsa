<?php

namespace Drupal\base_structure\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Drupal;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\base_structure\Service\BaseStructureService;

/**
 * @Block(
 *   id = "socials_block",
 *   admin_label = @Translation("Bloque para las redes sociales")
 * )
 */
 
class SocialsBlock extends BlockBase {

	public function build() {
		
		$service = Drupal::getContainer()->get('base_structure_service');

		$data["facebook"] = $service->getConfigText("facebook");
		$data["twitter"] = $service->getConfigText("twitter");
		$data["instagram"] = $service->getConfigText("instagram");
		$data["linkedin"] = $service->getConfigText("linkedin");
		$data["youtube"] = $service->getConfigText("youtube");
		$data["vimeo"] = $service->getConfigText("vimeo");
		$data["telegram"] = $service->getConfigText("telegram");
		$data["whatsapp"] = $service->getConfigText("whatsapp");
		
		$library['library'][] = 'base_structure/socials-styling';

		return [
			'#theme' => 'socials_block',
			'#data' => $data,
			'#titulo' => $this->t('Socials Block'),
			'#attached' => $library,
			'#cache' => [
				'max-age' => 0, 
				'tags' => ['node_list'], 
				'contexts' => ['url.path'], 
			],
		];
	}
}