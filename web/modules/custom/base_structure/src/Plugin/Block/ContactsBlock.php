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
 * 	 id = "contacts_block",
 * 	 admin_label = @Translation("Bloque para los datos de contacto")
 * )
 */
 
class ContactsBlock extends BlockBase {

    public function build(){

		$service = Drupal::getContainer()->get('base_structure_service');

        $data["logo"] = $service->getConfigURL("logo");
		$data["address"] = $service->getConfigText("address");
        $data["phone"] = $service->getConfigText("phone");
        $data["email"] = $service->getConfigText("email");
        $data["facebook"] = $service->getConfigText("facebook");
		$data["twitter"] = $service->getConfigText("twitter");
		$data["instagram"] = $service->getConfigText("instagram");
		$data["linkedin"] = $service->getConfigText("linkedin");
		$data["youtube"] = $service->getConfigText("youtube");
		$data["vimeo"] = $service->getConfigText("vimeo");
		$data["telegram"] = $service->getConfigText("telegram");
		$data["whatsapp"] = $service->getConfigText("whatsapp");
		
		$library['library'][] = 'base_structure/contacts-styling';
		
		return [
            '#theme' => 'contacts_block',
            '#titulo' => $this->t('Contacts Block'),
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
