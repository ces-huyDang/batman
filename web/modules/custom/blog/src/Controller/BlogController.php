<?php

namespace Drupal\blog\Controller;

use Drupal\blog\Services\BlogService;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Returns responses for Blog routes.
 *
 * @category Controller
 *
 * @package Custom
 * @author Display Name <huy.dang@codeenginestudio.com>
 * @license https://github.com/ces-huyDang huyDang Github
 * @link https://drupal10-blog.lndo.site/
 */
class BlogController extends ControllerBase {
  /**
   * Blog Service.
   *
   * @var \Drupal\blog\Services\BlogService
   */
  protected $blogService;

  /**
   * Constructs a new instance of the BlogService class.
   *
   * @param \Drupal\blog\Services\BlogService $blog_service
   *   to use method from BlogService.
   */
  public function __construct(BlogService $blog_service) {
    $this->$blogService = $blog_service;
  }

  /**
   * {@inheritdoc}
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Implemented by service container classes.
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
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
  public function blogs() {
    $posts = $this->$blogService->getPostList();
    return [
      '#theme' => 'blogs',
      '#data' => [
        'posts' => $posts,
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
  public function characters() {
    $terms = $this->$blogService->getTaxonomyTerms('characters');
    return new JsonResponse($terms);
  }

  /**
   * Gets carousel images uri to display on carousel.
   *
   * @return mixed
   *   Arrays of images uri.
   */
  public function carousel() {
    $images = $this->$blogService->getCarouselImagesUrl();
    if (!isset($images)) {
      return new JsonResponse(['error' => 'Internal Server Error'], 500);
    }
    return new JsonResponse($images);
  }

  /**
   * Get post by id and show information.
   *
   * @param string $nid
   *   Id from path.
   *
   * @return mixed
   *   Post with matched id.
   */
  public function details($nid) {
    $post = $this->$blogService->getPostById($nid);
    if (!isset($post)) {
      $message = 'Look like the post you looking for does not exists.';
      return [
        '#theme' => 'post_details',
        '#data' => [
          'message' => $message,
        ],
        '#attached' => [
          'library' => ['blog/details'],
        ],
      ];
    }
    return [
      '#theme' => 'post_details',
      '#data' => [
        'post' => $post,
      ],
      '#attached' => [
        'library' => ['blog/details'],
      ],
    ];
  }

  /**
   * Get post score by id and show information.
   *
   * @param string $nid
   *   Id from path.
   *
   * @return mixed
   *   Score info with matched id.
   */
  public function averageScore($nid) {
    $score = $this->$blogService->getAverageScore($nid);
    if (!isset($score)) {
      return new JsonResponse(['error' => 'Internal Server Error'], 500);
    }
    return new JsonResponse($score);
  }

  /**
   * Get current log in user.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   $user_info
   */
  public function currentUser() {
    $current_user = \Drupal::currentUser();
    $uid = $current_user->id();
    return new JsonResponse($uid);
  }

  /**
   * Add rating score for post.
   *
   * @param string $score_info
   *   Score information path.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   Response an annoucement.
   */
  public function rate($score_info) {
    $message = $this->$blogService->rating($score_info);
    return new JsonResponse($message);
  }

}
