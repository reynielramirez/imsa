<?php

namespace Drupal\base_structure\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal;

/**
 * @Block(
 * 	 id = "map_block",
 * 	 admin_label = @Translation("Bloque para el Mapa")
 * )
 */
 
class MapBlock extends BlockBase {

    public function build(){
        
		$library['library'][]= 'base_structure/map-styling';
		
		return [
            '#theme' => 'map_block',
            '#titulo' => 'Block Custom Title',
            '#descripcion' => 'Block Custom Description',
			'#attached'=> $library,
            '#cache' => [
                'max-age' => 0,
            ],
        ];
    }
}

?>
