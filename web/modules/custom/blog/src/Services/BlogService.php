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
     * Get the images URI by Id
     *
     * @param array $field_images field images of an Entity.
     *
     * @return array $images_uri.
     */
    public function getImagesUri($field_images)
    {
        $images_uri = [];
        foreach ($field_images as $field_image) {
            $media = Media::load($field_image['target_id']);
            $fid = $media->getSource()->getSourceFieldValue($media);
            $file = File::load($fid);
            $image_uri = $file->getFileUri();
            array_push($images_uri, $image_uri);
        }
        return $images_uri;
    }

        /**
         * Create a new array contains all needed Posts information.
         *
         * @param array $nodes nodes of Content type: Posts.
         *
         * @return array information of Posts.
         */
    public function getPostsInfo($nodes)
    {
        $posts_list = [];
        foreach ($nodes as $node) {
            $post_info = [];
            $node_id = $node->id();
            $node_title = $node->getTitle();
            $node_created = $node->getCreatedTime();
            $node_changed = $node->get('changed')->getValue()[0]['value'];
            $node_body = $node->get('body')->getValue()[0]['value'];
            $node_thumbnail_uri = $this->getImagesUri($node->get('field_thumbnail_image')->getValue());
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
            array_push($posts_list, $post_info);
        }
        return $posts_list;
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
    public function getCarouselImagesUri()
    {
        $content = $this->getAllContentByType('carousel_images');
        $album_id = (array_values($content)[0])
            ->get('field_carousel_images')->getValue()[0]['target_id'];
        $album = Node::load($album_id);
        $album_images = $album->get('field_album_images')->getValue();
        $image_uri = $this->getImagesUri($album_images);
        return $image_uri;
    }
}
