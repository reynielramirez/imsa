<?php

namespace Drupal\base_structure\Service;

use Drupal\Core\Entity\Query\QueryInterface;
use Drupal\file\Entity\File;
use Drupal;

class BaseStructureService {
    protected $config;

    public function __construct() {
        $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
        $config_name = 'general_contents_'.$language.'.settings';
        $this->config = \Drupal::configFactory()->getEditable($config_name);
    }
   
    public function getConfigText($id) {
        return $this->config->get($id);
    }

    public function getConfigFile($id) {
        
        $value = $this->getConfigText($id);
        return ($value)? File::load($value) : null;
    }

    public function getConfigURL($id) {
        $file = $this->getConfigFile($id);
        return ($file)? $file->getFileUri() : null;
    }

    public function Test() {
        
        $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
        $config_name = 'general_contents_'.$language.'.settings';
        return \Drupal::configFactory()->getEditable($config_name);

    }

    public function addGroup(&$form, $id, $title) { 

        $form[$id] = [
            '#type' => 'details',
            '#title' => t($title),
            '#open' => FALSE,
        ];

    }

    public function addTextfield(&$form, $group, $id, $title) { 

        $form[$group][$id] = [
            '#type' => 'textfield',
            '#title' => t($title),
            '#default_value' => $this->config->get($id),
            '#maxlength' => 50,
            '#description' => t('Admite hasta 50 caracteres.'),
        ];

    }

    public function addTextarea(&$form, $group, $id, $title) { 

        $form[$group][$id] = [
            '#type' => 'textarea',
            '#title' => t($title),
            '#rows' => 5,
            '#resizable' => 'vertical',
            '#default_value' => $this->config->get($id),
        ];

    }

    public function addRichTextarea(&$form, $group, $id, $title) { 

        $form[$group][$id] = [
            '#type' => 'text_format',
            '#title' => t($title),
            '#rows' => 5,
            '#resizable' => 'vertical',
            '#default_value' => $this->config->get($id),
        ];

    }

    public function addAddress(&$form, $group, $id, $title) { 

        $form[$group][$id] = [
            '#type' => 'textfield',
            '#title' => t($title),
            '#default_value' => $this->config->get($id),
            '#maxlength' => 200,
            '#description' => t('Admite hasta 200 caracteres.'),
        ];

    }

    public function addNumber(&$form, $group, $id, $title) { 

        $form[$group][$id] = [
            '#type' => 'textfield',
            '#title' => t($title),
            '#description' => 'número',
            '#default_value' => $this->config->get($id),
            '#maxlength' => 6,
            '#size' => 3,
        ];

    }

    public function addPhone(&$form, $group, $id, $title) { 
        
        $form[$group][$id] = [
            '#type' => 'tel',
            '#title' => t($title),
            '#default_value' => $this->config->get($id),
            '#maxlength' => 200,
            '#description' => t('Admite hasta 200 caracteres.'),
        ];

    }

    public function addEmail(&$form, $group, $id, $title) { 

        $form[$group][$id] = [
            '#type' => 'email',
            '#title' => t($title),
            '#default_value' => $this->config->get($id),
            '#description' => t('Debe tener el formato usuario@dominio.'),
        ];

    }

    public function addLink(&$form, $group, $id, $title) { 

        $form[$group][$id] = [
            '#type' => 'textfield',
            '#title' => t($title),
            '#description' => t('Link'),
            '#default_value' => $this->config->get($id),
            '#maxlength' => 255,
            '#size' => 64,      
        ];

    }

    public function addImage(&$form, $group, $id, $title) { 

        $form[$group][$id] = [
            '#type' => 'managed_file',
            '#title' => t($title),
            '#upload_location' => 'public://static/images',
            '#upload_validators' => [
                'FileExtension' => [
                    'extensions' => 'jpg jpeg png gif svg',
                ]
            ],
            '#default_value' => array($this->config->get($id)),
            '#description' => t('Allowed types:').' jpg, jpeg, png, gif, svg',
        ];

    }

    public function addImages(&$form, $group, $id, $title) { 

        $form[$group][$id] = [
            '#type' => 'managed_file',
            '#title' => t($title),
            '#upload_location' => 'public://static/images',
            '#upload_validators' => [
                'FileExtension' => [
                    'extensions' => 'jpg jpeg png gif svg',
                ]
            ],
            '#multiple' => TRUE,
            '#default_value' => $this->config->get($id),
            '#description' => t('Allowed types:').' jpg, jpeg, png, gif, svg',
        ];
    
    }

    public function addFile(&$form, $group, $id, $title) { 

        $form[$group][$id] = [
            '#type' => 'managed_file',
            '#title' => t($title),
            '#upload_location' => 'public://static/files',
            '#upload_validators' => [
                'FileExtension' => [
                    'extensions' => 'rar zip pdf doc docx ppt pptx xls xlsx',
                ],
            ],
            '#default_value' => array($this->config->get($id)),
            '#description' => t('Allowed types:').' pdf, rar, zip',
        ];
    
    }

    public function addFiles(&$form, $group, $id, $title) { 

        $form[$group][$id] = [
            '#type' => 'managed_file',
            '#title' => t($title),
            '#upload_location' => 'public://static/files',
            '#upload_validators' => [
                'FileExtension' => [
                    'extensions' => 'rar zip pdf doc docx ppt pptx xls xlsx',
                ],
            ],
            '#multiple' => TRUE,
            '#default_value' => $this->config->get($id),
            '#description' => t('Allowed types:').' pdf, rar, zip',
        ];
    
    }

    public function saveText($id, array &$data) {
        
        if (is_array($data[$id])) {
            $this->config->set($id, $data[$id]['value']);
        } else {
            $this->config->set($id, $data[$id]);
        }
    }

    public function saveImage($id, array &$data) {

        $image = $data[$id][0];
        $file = File::load($image);
        if ($file) {
            $file->setPermanent();
            $file->save();
        }
        $this->config->set($id, $image);

    }

    public function saveImages($id, array &$data) {

        foreach($data[$id] as $image) {
            $file = File::load($image);
            if ($file) {
                $file->setPermanent();
                $file->save();
            }
        }
        $this->config->set($id, $data[$id]);
 
    }

    public function saveFile($id, array &$data) {

        $value = $data[$id][0];
        $file = File::load($value);
        if ($file) {
            $file->setPermanent();
            $file->save();
        }
        $this->config->set($id, $value);

    }

    public function saveFiles($id, array &$data) {

        foreach($data[$id] as $item) {
            $file = File::load($item);
            if ($file) {
                $file->setPermanent();
                $file->save();
            }
        }
        $this->config->set($id, $data[$id]);

    }

    public function saveConfig(){
        $this->config->save();
    }

        public function addFormattedTextarea(&$form, $group, $id, $title) {
        $default_value = $this->config->get($id);
        if (!is_array($default_value)) {
            $default_value = [
                'value' => $default_value,
                'format' => 'basic_html', // Cambia esto si tu formato por defecto es otro
            ];
        }
        $form[$group][$id] = [
            '#type' => 'text_format',
            '#title' => t($title),
            '#format' => $default_value['format'],
            '#default_value' => $default_value['value'],
            '#rows' => 8,
            '#description' => t('Puedes usar formato HTML básico.'),
        ];
    }

    public function clearProductos()
    {
        $database = Drupal::database();

        // Método más agresivo: eliminar usando LEFT JOIN
        $deleted = $database->query("
            DELETE fr 
            FROM node__field_productos fr
            LEFT JOIN node_field_data n ON fr.entity_id = n.nid
            WHERE n.nid IS NULL
        ")->execute();

        $deleted2 = $database->query("
            DELETE fr 
            FROM node__field_productos fr
            LEFT JOIN node_field_data n ON fr.field_productos_target_id = n.nid
            WHERE n.nid IS NULL
        ")->execute();

        // También limpiar la tabla de revisiones
        $database->query("
            DELETE fr 
            FROM node_revision__field_productos fr
            LEFT JOIN node_field_data n ON fr.entity_id = n.nid
            WHERE n.nid IS NULL
        ")->execute();

        $database->query("
            DELETE fr 
            FROM node_revision__field_productos fr
            LEFT JOIN node_field_data n ON fr.field_productos_target_id = n.nid
            WHERE n.nid IS NULL
        ")->execute();

        \Drupal::logger('debug')->debug('Registros eliminados de node__field_productos (padre): @count', ['@count' => $deleted]);
        \Drupal::logger('debug')->debug('Registros eliminados de node__field_productos (hijo): @count', ['@count' => $deleted2]);

        // Verificar cuántos registros quedan
        $restantes = $database->select('node__field_productos', 'f')
            ->countQuery()
            ->execute()
            ->fetchField();

        \Drupal::logger('debug')->debug('Registros restantes en node__field_productos: @count', ['@count' => $restantes]);

        // Mostrar las relaciones que quedan (deberían ser solo las válidas)
        if ($restantes > 0) {
            $relaciones = $database->select('node__field_productos', 'f')
                ->fields('f', ['entity_id', 'field_productos_target_id'])
                ->execute()
                ->fetchAll();
            
            foreach ($relaciones as $rel) {
                \Drupal::logger('debug')->debug('Relación válida: Padre @padre -> Hijo @hijo', [
                    '@padre' => $rel->entity_id,
                    '@hijo' => $rel->field_productos_target_id
                ]);
            }
        }

        $database = Drupal::database();

        // Ver todos los productos activos
        $todos_ids = Drupal::entityQuery('node')
            ->condition('type', 'products')
            ->condition('status', 1)
            ->accessCheck(FALSE)
            ->execute();

        \Drupal::logger('debug')->debug('=== PRODUCTOS ACTIVOS ===');
        \Drupal::logger('debug')->debug('IDs: @ids', ['@ids' => implode(', ', $todos_ids)]);

        // Obtener subproductos (ahora solo los válidos)
        $subproductos_ids = $database->select('node__field_productos', 'f')
            ->fields('f', ['field_productos_target_id'])
            ->distinct()
            ->execute()
            ->fetchCol();

        \Drupal::logger('debug')->debug('=== SUBPRODUCTOS VÁLIDOS ===');
        \Drupal::logger('debug')->debug('IDs: @ids', ['@ids' => implode(', ', $subproductos_ids)]);

        // Resultado final
        $resultado_final = array_diff($todos_ids, $subproductos_ids);
        \Drupal::logger('debug')->debug('=== PRODUCTOS NO SUBPRODUCTOS ===');
        \Drupal::logger('debug')->debug('IDs: @ids', ['@ids' => implode(', ', $resultado_final)]);
    }

}