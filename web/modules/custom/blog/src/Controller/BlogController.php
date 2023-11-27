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
     * @param ContainerInterface $container implemented by service container classes.
     * 
     * @return static
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
     *   Arrays of Posts information.
     */
    public function blogs()
    {
        $posts = $this->blog_service->getPostList();
        $score_list = $this->blog_service->getScoreList();
        return [
        '#theme' => 'blogs',
        '#data' => [
        'posts' => $posts
        ],
        '#attached' => [
        'library' => ['blog/homepage'],
        ],
        ];
    }

    /**
     * Gets Characters terms data to display on dropdown menu.
     *
     * @return mixed
     *   Arrays of Characters terms information.
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
     *   Arrays of images uri.
     */
    public function carousel()
    {
        $images = $this->blog_service->getCarouselImagesUrl();
        return new JsonResponse($images);
    }

    /**
     * Get post by id and show information.
     *
     * @param string $nid Id from path.
     *  
     * @return mixed
     *   Post with matched id.
     */
    public function details($nid) 
    {
        $post = $this->blog_service->getPostById($nid);
        if (!$post) {
            $message = 'Look like the post you looking for does not exists.';
            return [
            '#theme' => 'post-details',
            '#data' => [
            'message' => $message
            ],
            '#attached' => [
            'library' => ['blog/details'],
            ],
            ];
        }
            return [
            '#theme' => 'post-details',
            '#data' => [
            'post' => $post
            ],
            '#attached' => [
            'library' => ['blog/details'],
            ],
            ];
    }

    /**
     * Get post score by id and show information.
     *
     * @param string $nid Id from path.
     *  
     * @return mixed
     *   Score info with matched id.
     */
    public function score($nid)
    {
        $score = $this->blog_service->getPostScore($nid);
        if (!$score) {
            return new JsonResponse(['error' => 'Internal Server Error'], 500);
        }
        return new JsonResponse($score);
    }

    /**
     * Get current log in user
     * 
     * @return JsonResponse
     *  $user_info
     */
    public function currentUser() 
    {
        $current_user = \Drupal::currentUser();
        $uid = $current_user->id();
        return new JsonResponse($uid);
    }

    /**
     * Add rating score for post
     * 
     * @param string $score_info score information path.
     * 
     * @return JsonResponse
     *  Response an annoucement.
     */
    public function rate($score_info)
    {
        $message = $this->blog_service->rating($score_info);
        return new JsonResponse($message);
    }
}
