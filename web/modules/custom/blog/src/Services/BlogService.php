<?php

namespace Drupal\blog\Services;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\file\Entity\File;
use Drupal\media\Entity\Media;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\taxonomy\Entity\Term;
use Drupal\user\Entity\User;

/**
 * Contains all the method to handle request of the site.
 *
 * @category Service
 *
 * @package Custom
 * @author Display Name <huy.dang@codeenginestudio.com>
 * @license https://github.com/ces-huyDang huyDang Github
 * @link https://drupal10-blog.lndo.site/
 */
class BlogService {
  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructor for EntityTypeManagerInterface.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   the entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * Get all content of a specific content type.
   *
   * @param string $content_type
   *   the machine name of the content type.
   *
   * @return array an array of content entities of the specified content type.
   */
  public function getAllContentByType($content_type) {
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $query->accessCheck(TRUE);
    $query->condition('type', $content_type);
    $query->condition('status', 1);
    $query->sort('created', 'DESC');
    $nids = $query->execute();
    $nodes = Node::loadMultiple($nids);
    return $nodes;
  }

  /**
   * Get the images src by Id (URI/URL)
   *
   * @param array $field_images
   *   field images of an Entity.
   * @param string $src_type
   *   "uri" or "url.
   *
   * @return array $images_src.
   */
  public function getImagesSrc($field_images, $src_type) {
    if ($src_type !== "url" && $src_type !== "uri") {
      return [];
    }
    $images_src = [];
    foreach ($field_images as $field_image) {
      $media = Media::load($field_image['target_id']);
      $fid = $media->getSource()->getSourceFieldValue($media);
      $file = File::load($fid);
      $image_uri = $file->getFileUri();
      if ($src_type === "uri") {
        array_push($images_src, $image_uri);
      }
      else {
        $image_url = \Drupal::service('file_url_generator')
          ->generateAbsoluteString($image_uri);
        array_push($images_src, $image_url);
      }
    }
    return $images_src;
  }

  /**
   * Create a new array contains all needed Post information.
   *
   * @param \Drupal\node\Entity\Node $node
   *   nodes of Content type: Posts.
   *
   * @return array information of Post.
   */
  public function getPostInfo($node) {
    $post_info = [];
    $node_id = $node->get('nid')->getValue()[0]['value'];
    $node_title = $node->getTitle();
    $node_created = $node->getCreatedTime();
    if (!$node->get('changed')->isEmpty()) {
      $node_changed = $node->get('changed')->getValue()[0]['value'];
    }
    if ($node->get('body')->isEmpty()) {
      $node_body = '';
    }
    else {
      $node_body = $node->get('body')->getValue()[0]['value'];
    }
    // Check the content type of node to get image URI on the right field.
    if ($node->get('type')->getValue()[0]['target_id'] === "posts") {
      $node_is_featured = $node->get('field_is_featured')
        ->getValue()[0]['value'];
      $node_thumbnail_uri = $this->getImagesSrc(
            $node->get('field_thumbnail_image')
              ->getValue(), "uri"
        );
      $node_is_featured
              ? $post_info['is_featured'] = TRUE
              : $post_info['is_featured'] = FALSE;
    }
    else {
      $node_thumbnail_uri = $this->getImagesSrc(
            $node->get('field_movie_thumbnail')
              ->getValue(), "uri"
        );
    }
    $node_uid = $node->get('uid')->getValue()[0]['target_id'];
    $node_user = User::load($node_uid);
    $post_info['id'] = $node_id;
    $post_info['title'] = $node_title;
    $post_info['created'] = $node_created;
    $post_info['changed'] = $node_changed;
    $post_info['body'] = $node_body;
    $post_info['thumbnail_uri'] = $node_thumbnail_uri;
    $post_info['uid'] = $node_user->id();
    $post_info['user_name'] = $node_user->getAccountName();
    return $post_info;
  }

  /**
   * Get Posts list to display on index.
   *
   * @return array list of Post.
   */
  public function getPostList() {
    $nodes = $this->getAllContentByType('posts');
    $post_list = [];
    foreach ($nodes as $node) {
      $post = $this->getPostInfo($node);
      array_push($post_list, $post);
    }
    return $post_list;
  }

  /**
   * Get all terms of a taxonomy by vocabulary machine name.
   *
   * @param string $vocabulary_machine_name
   *   The vocabulary machine name.
   *
   * @return array an array of term info.
   */
  public function getTaxonomyTerms($vocabulary_machine_name) {
    $query = $this->entityTypeManager->getStorage('taxonomy_term')->getQuery();
    $query->accessCheck(TRUE);
    $query->condition('vid', $vocabulary_machine_name);
    $tids = $query->execute();
    $terms = Term::loadMultiple($tids);
    $terms_info = $this->getTermsInfo($terms);
    return $terms_info;
  }

  /**
   * Create a new array contains all needed Terms information.
   *
   * @param array $terms
   *   Terms from db.
   *
   * @return array information of Terms.
   */
  public function getTermsInfo($terms) {
    $terms_list = [];
    foreach ($terms as $term) {
      $term_info = [];
      $tid = $term->id();
      $term_name = $term->getName();
      $term_info['tid'] = $tid;
      $term_info['term_name'] = $term_name;
      array_push($terms_list, $term_info);
    }
    return $terms_list;
  }

  /**
   * Create a new array contains all carousel images info.
   *
   * @return array|null information carousel images.
   */
  public function getCarouselImagesUrl() {
    $content = $this->getAllContentByType('carousel_images');
    if (isset($content)) {
      $album_id = (array_values($content)[0])
        ->get('field_carousel_images')->getValue()[0]['target_id'];
      $album = Node::load($album_id);
      $album_images = $album->get('field_album_images')->getValue();
      $images_url = $this->getImagesSrc($album_images, "url");
      $carousel_images_url = [];
      foreach ($images_url as $index => $image_url) {
        $carousel_image = [];
        $carousel_image['id'] = $index;
        $carousel_image['url'] = $image_url;
        array_push($carousel_images_url, $carousel_image);
      }
      return $carousel_images_url;
    }
    else {
      return NULL;
    }
  }

  /**
   * Get a Post content by nid.
   *
   * @param string $nid
   *   Nid from Controller.
   *
   * @return array|null a Post with matched Id || null.
   */
  public function getPostById(string $nid) {
    if (!is_numeric($nid) || empty($nid)) {
      return NULL;
    }
    $node = Node::load($nid);
    if (!isset($node)) {
      return NULL;
    }
    $type = $node->get('type')->getValue()[0]['target_id'];
    if ($type !== 'posts') {
      return NULL;
    }
    $post = $this->getPostInfo($node);
    return $post;
  }

  // Average Score.

  /**
   * Calculate a Post average score by nid.
   *
   * @param string $nid
   *   Id from Controller.
   *
   * @return array|null Post's score info.
   */
  public function calculateAverageScore(string $nid) {
    if (!is_numeric($nid) || empty($nid)) {
      return NULL;
    }
    $node = Node::load($nid);
    if (!isset($node)) {
      return NULL;
    }
    $score_info = [];
    $total_score = 0;
    $score_ids = $node->get('field_users_score')->getValue();
    if ($score_ids) {
      foreach ($score_ids as $score_id) {
        $paragraph = Paragraph::load($score_id['target_id']);
        $score = $paragraph->get('field_user_score')->getValue()[0]['value'];
        $total_score += $score;
      }
      $score_info['voted_users'] = count($score_ids);
      $score_info['average_score'] = $total_score / count($score_ids);
    }
    else {
      $score_info['voted_users'] = NULL;
      $score_info['average_score'] = NULL;
    }
    return $score_info;
  }

  /**
   * Get voted uids.
   *
   * @param string $nid
   *   Id from Controller.
   *
   * @return array|null voted uids
   */
  public function getVotedUserIds(string $nid) {
    if (!is_numeric($nid) || empty($nid)) {
      return NULL;
    }
    $node = Node::load($nid);
    if (!$node) {
      return NULL;
    }
    $score_ids = $node->get('field_users_score')->getValue();
    $voted_uids = [];
    foreach ($score_ids as $score_id) {
      $score = Paragraph::load($score_id['target_id']);
      if (!$score) {
        continue;
      }
      $voted_uid = $score->get('field_voted_user')[0]->getValue()['target_id'];
      array_push($voted_uids, $voted_uid);
    }
    return $voted_uids;
  }

  /**
   * Add a rating score for Post with matched Id.
   *
   * @param string $score_info
   *   Score info from Controller.
   *
   * @return string an annoucement.
   */
  public function rating($score_info) {
    $message = NULL;
    $decoded_score_info = json_decode(urldecode($score_info));
    $node = Node::load($decoded_score_info->nid);
    $voted_uids = $this->getVotedUserIds($decoded_score_info->nid);
    if ($voted_uids && in_array($decoded_score_info->uid, $voted_uids)) {
      $query = $this->entityTypeManager->getStorage('paragraph')->getQuery();
      $query->accessCheck(TRUE);
      $query->condition('type', 'user_score');
      $query->condition('field_voted_user', $decoded_score_info->uid);
      $query->condition('parent_id', $decoded_score_info->nid);
      $score_id = $query->execute();
      $score = Paragraph::load(array_values($score_id)[0]);
      $score->set('field_user_score', $decoded_score_info->score);
      $score->save();
      $message = 'Modified your score rating!';
    }
    else {
      $new_score = Paragraph::create(
            [
              'type' => 'user_score',
              'field_user_score' => $decoded_score_info->score,
              'field_voted_user' => $decoded_score_info->uid,
            ]
        );
      $new_score->isNew();
      $new_score->save();
      $field_users_score = $node->get('field_users_score')->getValue();
      $new_score_id = [];
      $new_score_id['target_id'] = $new_score->id();
      $new_score_id['target_revision_id'] = $new_score->getRevisionId();
      array_push($field_users_score, $new_score_id);
      $node->set('field_users_score', $field_users_score);
      $node->save();
      $message = 'Add new Score!';
    }
    $score_info = $this->calculateAverageScore($decoded_score_info->nid);
    $paragraph = Paragraph::create(
          [
            'type' => 'average_score',
            'field_score' => $score_info['average_score'],
            'field_voted_users' => $score_info['voted_users'],
          ]
      );
    $paragraph->save();
    $node->set('field_average_score', $paragraph);
    $node->save();
    return $message;
  }

  /**
   * Get a Post score by nid.
   *
   * @param string $nid
   *   Id from Controller.
   *
   * @return array|null Post's field average score.
   */
  public function getAverageScore($nid) {
    if (!is_numeric($nid) || empty($nid)) {
      return NULL;
    }
    $node = Node::load($nid);
    if (!isset($node)) {
      return NULL;
    }
    $pid = $node->get('field_average_score')->getValue()[0]['target_id'];
    if (!$pid) {
      $score_info['average_score'] = NULL;
      $score_info['voted_users'] = NULL;
    }
    else {
      $average_score = Paragraph::load($pid);
      $score_info = [];
      $score_info['average_score'] = $average_score->get('field_score')
        ->getValue()[0]['value'];
      $score_info['voted_users'] = $average_score->get('field_voted_users')
        ->getValue()[0]['value'];
    }
    return $score_info;
  }

  /**
   * Get a list of posts and its average score.
   *
   * @return array Posts list with average score.
   */
  public function getAverageScores() {
    $score_list = [];
    $posts_list = $this->getAllContentByType("posts");
    foreach ($posts_list as $post) {

      $score = $this->calculateAverageScore($post->id());
      if (!$score['average_score']) {
        continue;
      }
      $score_info = [];
      $score_info['score'] = $score['average_score'];
      $score_info['post_name'] = $post->get('title')->getValue()[0]['value'];
      array_push($score_list, $score_info);
    }
    return $score_list;
  }

  // Meta Score.

  /**
   * Calculate a Post meta score by nid.
   *
   * @param string $nid
   *   Id from Controller.
   *
   * @return array|null Post's meta score info.
   */
  public function calculateMetaScore(string $nid) {
    if (!is_numeric($nid) || empty($nid)) {
      return NULL;
    }
    $node = Node::load($nid);
    if (!isset($node)) {
      return NULL;
    }
    $score_info = [];
    $total_score = 0;
    if ($node->get('field_users_score')->isEmpty()) {
      return NULL;
    }
    $score_ids = $node->get('field_users_score')->getValue();
    foreach ($score_ids as $score_id) {
      $paragraph = Paragraph::load($score_id['target_id']);
      $score = $paragraph->get('field_user_score')->getValue()[0]['value'];
      $total_score += $score;
    }
    $score_info['voted_users'] = count($score_ids);
    $score_info['meta_score'] = $total_score;
    return $score_info;
  }

  /**
   * Get a list of posts and its meta score.
   *
   * @return array Posts list with meta score.
   */
  public function getMetaScores() {
    $score_list = [];
    $posts_list = $this->getAllContentByType("posts");
    foreach ($posts_list as $post) {
      $score = $this->calculateMetaScore($post->id());
      if (!isset($score['meta_score']) || !isset($score)) {
        continue;
      }
      $score_info = [];
      $score_info['score'] = $score['meta_score'];
      $score_info['post_name'] = $post->get('title')->getValue()[0]['value'];
      if (!$post->get('field_thumbnail_image')->isEmpty()) {
        $score_info['image_uri'] = $this->getImagesSrc(
              $post->get('field_thumbnail_image')
                ->getValue(), "uri"
          );
      }
      array_push($score_list, $score_info);
    }
    return $score_list;
  }

  /**
   * Get all Movies with Category: Series .
   *
   * @return array Movies list with category: Series
   */
  public function getSeriesMovie() {
    $term_name = 'Series';
    $term_query = $this->entityTypeManager->getStorage('taxonomy_term')
      ->getQuery();
    $term_query->accessCheck(TRUE);
    $term_query->condition("name", $term_name);
    $tid = $term_query->execute();
    $node_query = $this->entityTypeManager->getStorage('node')
      ->getQuery();
    $node_query->accessCheck(FALSE);
    $node_query->condition('type', 'movie');
    $node_query->condition('status', 1);
    $node_query->condition('field_category', array_values($tid)[0]);
    $nodes = $node_query->execute();
    $movies_info = [];
    foreach ($nodes as $node) {
      $movie = $this->getPostInfo(Node::load($node));
      array_push($movies_info, $movie);
    }
    return $movies_info;
  }

}
