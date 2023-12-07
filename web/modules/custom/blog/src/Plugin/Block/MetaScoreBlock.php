<?php

namespace Drupal\blog\Plugin\Block;

use Drupal\blog\Services\BlogService;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Create a block of carousel to display on index.
 *
 * @Block(
 *  id = "meta_score_block",
 *  admin_label = @Translation("Meta Score Block"),
 *  category = @Translation("Custom"),
 * )
 */
class MetaScoreBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * Blog Service.
   *
   * @var \Drupal\blog\Services\BlogService
   */
  protected $blogService;

  /**
   * {@inheritDoc}
   *
   * @param \Drupal\blog\Services\BlogService $blog_service
   *   To use method from BlogService.
   * @param array $configuration
   *   Configuration.
   * @param string $plugin_id
   *   Plugin_id.
   * @param mixed $plugin_definition
   *   Plugin_definition.
   */
  public function __construct(BlogService $blog_service, array $configuration, $plugin_id, $plugin_definition,) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->$blogService = $blog_service;
  }

  /**
   * {@inheritDoc}
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Container.
   * @param array $configuration
   *   Configuration.
   * @param string $plugin_id
   *   Plugin_id.
   * @param mixed $plugin_definition
   *   Plugin_definition.
   *
   * @return static
   */
  public static function create(
        ContainerInterface $container,
        array $configuration,
        $plugin_id,
        $plugin_definition
    ) {
    return new static(
          $container->get('blog.service'),
          $configuration,
          $plugin_id,
          $plugin_definition,
      );
  }

  /**
   * {@inheritDoc}
   */
  public function build() {
    $scores = $this->$blogService->getMetaScores();
    return [
      '#theme' => 'meta_score',
      '#data' => [
        'scores' => $scores,
      ],
    ];
  }

}
