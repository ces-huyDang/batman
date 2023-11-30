<?php

/**
 * Blog module Block file
 * 
 * This file handles all requests of the site
 * php version 8.1.2-1ubuntu2.14 (cli)
 *
 * @category Custom
 * 
 * @package Custom
 * @author  Display Name <huy.dang@codeenginestudio.com>
 * @license https://github.com/ces-huyDang huyDang Github
 * @link    https://drupal10-blog.lndo.site/
 */
namespace Drupal\blog\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\blog\Services\BlogService;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Create a block of carousel to display on index
 * 
 * @Block(
 *  id = "meta_score_block",
 *  admin_label = @Translation("Meta Score Block"),
 *  category = @Translation("Custom"),
 * )
 */
class MetaScoreBlock extends BlockBase implements ContainerFactoryPluginInterface
{
      /**
       * Blog Service
       * 
       * @var \Drupal\blog\Services\BlogService
       */
    protected $blog_service;

    /**
     * {@inheritDoc}
     * 
     * @param BlogService $blog_service      to use method from BlogService.
     * @param array       $configuration     configuration.
     * @param string      $plugin_id         plugin_id.
     * @param mixed       $plugin_definition plugin_definition.
     */
    public function __construct(BlogService $blog_service, array $configuration, $plugin_id, $plugin_definition,)
    {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->blog_service = $blog_service;
    }

    /**
     * {@inheritDoc}
     * 
     * @param ContainerInterface $container         container.
     * @param array              $configuration     configuration.
     * @param string             $plugin_id         plugin_id.
     * @param mixed              $plugin_definition plugin_definition.
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
     * 
     * @return mixed
     */
    public function build()
    {
        $scores = $this->blog_service->getMetaScores();
        return [
        '#theme' => 'meta_score',
        '#data' => [
          'scores' => $scores
          ],
        ];
    }
}
