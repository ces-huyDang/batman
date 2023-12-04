<?php

/**
 * Blog module Block file
 * 
 * This file handles all requests of the site
 * php version 8.1.2-1ubuntu2.14 (cli)
 *
 * @category Block
 * 
 * @package Custom
 * @author  Display Name <huy.dang@codeenginestudio.com>
 * @license https://github.com/ces-huyDang huyDang Github
 * @link    https://drupal10-blog.lndo.site/
 */
namespace Drupal\blog\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Create a block of carousel to display on index
 * 
 * @Block(
 *  id = "carousel_block",
 *  admin_label = @Translation("Carousel Block"),
 *  category = @Translation("Custom"),
 * )
 */

class CarouselBlock extends BlockBase
{
    /**
     * {@inheritDoc}
     */
    public function build()
    {
        return [
          '#theme' => 'carousel',
        ];
    }
}
