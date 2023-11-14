<?php

/**
 * Blog module Service file
 * 
 * This file handles all requests of the site
 * php version 8.1.2-1ubuntu2.14 (cli)
 *
 * @category Service
 * 
 * @package Custom
 * @author  Display Name <huy.dang@codeenginestudio.com>
 * @license https://github.com/ces-huyDang huyDang Github
 * @link    https://drupal10-blog.lndo.site/
 */

namespace Drupal\blog\Services;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\media\Entity\Media;
use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;
use Drupal\user\Entity\User;
use Drupal\paragraphs\Entity\Paragraph;

/**
 * Contains all the method to handle request of the site.
 * 
 * @category Service
 * 
 * @package Custom
 * @author  Display Name <huy.dang@codeenginestudio.com>
 * @license https://github.com/ces-huyDang huyDang Github
 * @link    https://drupal10-blog.lndo.site/
 */
class BlogService
{
    /**
     * The entity type manager.
     *
     * @var \Drupal\Core\Entity\EntityTypeManagerInterface
     */
    protected $entityTypeManager;

    /**
     * Constructor for EntityTypeManagerInterface.
     *
     * @param EntityTypeManagerInterface $entityTypeManager the entity type manager
     */
    public function __construct(EntityTypeManagerInterface $entityTypeManager)
    {
        $this->entityTypeManager = $entityTypeManager;
    }


    /**
     * Get all content of a specific content type.
     *
     * @param string $content_type the machine name of the content type.
     *
     * @return array an array of content entities of the specified content type.
     */
    public function getAllContentByType($content_type)
    {
        $query = $this->entityTypeManager->getStorage('node')->getQuery();
        $query->accessCheck(true);
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
     * @param array  $field_images field images of an Entity.
     * @param string $src_type     "uri" or "url
     *
     * @return array $images_src.
     */
    public function getImagesSrc($field_images, $src_type)
    {
        if ($src_type !== "url" && $src_type !== "uri") {
            return [];
        }
        $images_src = [];
        foreach ($field_images as $field_image) {
            $media = Media::load($field_image['target_id']);
            $fid = $media->getSource()->getSourceFieldValue($media);
            $file = File::load($fid);
            $image_uri = $file->getFileUri();
            $image_url = \Drupal::service('file_url_generator')
            ->generateAbsoluteString($image_uri);
            if ($src_type === "uri") {
                array_push($images_src, $image_uri);
            } else {
                array_push($images_src, $image_url);
            }
        }
        return $images_src;
    }

    /**
     * Create a new array contains all needed Post information.
     *
     * @param Node $node nodes of Content type: Posts.
     *
     * @return array information of Post.
     */
    public function getPostInfo($node)
    {
        $post_info = [];
        $node_id = $node->get('nid')->getValue()[0]['value'];
        $node_title = $node->getTitle();
        $node_created = $node->getCreatedTime();
        $node_changed = $node->get('changed')->getValue()[0]['value'];
        $node_body = $node->get('body')->getValue()[0]['value'];
        $node_thumbnail_uri = $this->getImagesSrc(
            $node->get('field_thumbnail_image')
                ->getValue(), "uri"
        );
        $node_uid = $node->get('uid')->getValue()[0]['target_id'];
        $node_is_featured = $node->get('field_is_featured')->getValue()[0]['value'];
        $node_user = User::load($node_uid);
        $post_info['id'] = $node_id;
        $post_info['title'] = $node_title;
        $post_info['created'] = $node_created;
        $post_info['changed'] = $node_changed;
        $post_info['body'] = $node_body;
        $post_info['thumbnail_uri'] = $node_thumbnail_uri;
        $post_info['uid'] = $node_user->id();
        $post_info['user_name'] = $node_user->getAccountName();
        if ($node_is_featured) {
            $post_info['is_featured'] = true;
        } else {
            $post_info['is_featured'] = false;
        }
        return $post_info;
    }

    /**
     * Get Posts list to display on index.
     *
     * @return array list of Post.
     */
    public function getPostList()
    {
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
     * @param string $vocabulary_machine_name the vocabulary machine name
     *   
     * @return array an array of term info.
     */
    public function getTaxonomyTerms($vocabulary_machine_name)
    {
        $query = $this->entityTypeManager->getStorage('taxonomy_term')->getQuery();
        $query->accessCheck(true);
        $query->condition('vid', $vocabulary_machine_name);
        $tids = $query->execute();
        $terms = Term::loadMultiple($tids);
        $terms_info = $this->getTermsInfo($terms);
        return $terms_info;
    }

    /**
     * Create a new array contains all needed Terms information.
     *
     * @param array $terms terms from db
     *
     * @return array information of Terms.
     */
    public function getTermsInfo($terms)
    {
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
     * Create a new array contains all needed Terms information.
     *
     * @return array information of Terms.
     */
    public function getCarouselImagesUrl()
    {
        $content = $this->getAllContentByType('carousel_images');
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

    /**
     * Get a Post content by nid.
     * 
     * @param string $nid nid from Controller.
     *
     * @return array|null a Post with matched Id || null.
     */
    public function getPostById(string $nid)
    {
        $node = Node::load($nid);
        if (!$node) {
            return null;
        }
        $type = $node->get('type')->getValue()[0]['target_id'];
        if ($type !== 'posts') {
            return null;
        }
        $post = $this->getPostInfo($node);
        return $post;
    }

    /**
     * Calculate a Post score by nid.
     * 
     * @param string $nid id from Controller.
     * 
     * @return array|null Post's score info.
     */
    public function calculateAverageScore(string $nid)
    {
        $node = Node::load($nid);
        $score_info = [];
        $total_score = 0;
        $score_ids = $node->get('field_users_score')->getValue();
        foreach ($score_ids as $score_id) {
            $paragraph = Paragraph::load($score_id['target_id']);
            $score = $paragraph->get('field_user_score')->getValue()[0]['value'];
            $total_score += $score;
        }
        $score_info['voted_users'] = count($score_ids);
        $score_info['average_score'] = $total_score / count($score_ids);
        return $score_info;
    }

    /**
     * Get voted uids
     * 
     * @param string $nid id from Controller.
     * 
     * @return array|null voted uids
     */
    public function getVotedUserIds(string $nid)
    {
        $node = Node::load($nid);
        if (!$node) {
            return null;
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
     * Add a rating score for Post with matched Id
     * 
     * @param string $score_info from Controller.
     * 
     * @return string an annoucement.
     */
    public function rating($score_info)
    {
        $message = null;
        $decoded_score_info = json_decode(urldecode($score_info));
        $node = Node::load($decoded_score_info->nid);
        $voted_uids = $this->getVotedUserIds($decoded_score_info->nid);
        if ($voted_uids && in_array($decoded_score_info->uid, $voted_uids)) {
            $query = $this->entityTypeManager->getStorage('paragraph')->getQuery();
            $query->accessCheck(true);
            $query->condition('type', 'user_score');
            $query->condition('field_voted_user', $decoded_score_info->uid);
            $query->condition('parent_id', $decoded_score_info->nid);
            $score_id = $query->execute();
            $score = Paragraph::load(array_values($score_id)[0]);
            $score->set('field_user_score', $decoded_score_info->score);
            $score->save();
              $message = 'Modified your score rating!';
        } else {
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
            'field_voted_users' => $score_info['voted_users']
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
     * @param string $nid id from Controller.
     * 
     * @return array|null Post's field average score.
     */
    public function getAverageScore($nid)
    {
        $node = Node::load($nid);
        $pid = $node->get('field_average_score')->getValue()[0]['target_id'];
        if (!$pid) {
            $score_info['average_score'] = null;
            $score_info['voted_users'] = null;
        } else {
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
     * Get a list of posts and its score
     * 
     * @return array Posts list with score.
     */
    public function getAverageScores()
    {
        $score_list = [];
        $posts_list = $this->getAllContentByType("posts");
        foreach ($posts_list as $post) {

            $score = $this->calculateAverageScore($post->id());
            if (!$score['average_score']) {
                continue;
            }
            $score_info = [];
            $score_info['average_score'] = $score['average_score'];
            $score_info['post_name'] = $post->get('title')->getValue()[0]['value'];
            array_push($score_list, $score_info);
        }
        return $score_list;
    }
}
