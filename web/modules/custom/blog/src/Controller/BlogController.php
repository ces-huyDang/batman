<?php

/**
 * Blog module Controller file
 * 
 * This file handles all requests of the site
 * php version 8.1.2-1ubuntu2.14 (cli)
 *
 * @category Controller
 * 
 * @package Custom
 * @author  Display Name <huy.dang@codeenginestudio.com>
 * @license https://github.com/ces-huyDang huyDang Github
 * @link    https://drupal10-blog.lndo.site/
 */
namespace Drupal\blog\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\blog\Services\BlogService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Returns responses for Blog routes.
 * 
 * @category Controller
 * 
 * @package Custom
 * @author  Display Name <huy.dang@codeenginestudio.com>
 * @license https://github.com/ces-huyDang huyDang Github
 * @link    https://drupal10-blog.lndo.site/
 */
class BlogController extends ControllerBase
{
    /**
     * Blog Service
     * 
     * @var \Drupal\blog\Services\BlogService
     */
    protected $blog_service;

    /**
     * Constructs a new instance of the BlogService class.
     * 
     * @param BlogService $blog_service to use method from BlogService.
     */
    public function __construct(BlogService $blog_service)
    {
        $this->blog_service = $blog_service;
    }

    /**
     * {@inheritdoc}
     *
     * @param ContainerInterface $container implemented by service container classes
     * 
     * @return mixed
     */
    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('blog.service'),
        );
    }

    /**
     * Gets posts data and display on index.
     *
     * @return mixed
     *   Arrays of Posts information
     */
    public function index()
    {
        $nodes = $this->blog_service->getAllContentByType('posts');
        $posts = $this->blog_service->getPostsInfo($nodes);
        return [
        '#theme' => 'index',
        '#data' => [
        'posts' => $posts
        ],
        '#attached' => [
        'library' => ['blog/blog'],
        ],
        ];
    }

    /**
     * Gets Characters terms data to display on dropdown menu.
     *
     * @return mixed
     *   Arrays of Characters terms information
     */
    public function characters()
    {
        $terms = $this->blog_service->getTaxonomyTerms('characters');
        return new JsonResponse($terms);
    }

    /**
     * Gets carousel images uri to display on carousel.
     *
     * @return mixed
     *   Arrays of images uri
     */
    public function carousel()
    {
        $images = $this->blog_service->getCarouselImagesUri();
        return [
        '#theme' => 'carousel',
        '#data' => [
          'images' => $images
          ],
        '#attached' => [
        'library' => ['blog/blog'],
        ],
        ];
    }
}
