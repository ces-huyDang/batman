<?php

namespace Drupal\blog\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Create a block of carousel to display on index.
 *
 * @Block(
 *  id = "carousel_block",
 *  admin_label = @Translation("Carousel Block"),
 *  category = @Translation("Custom"),
 * )
 */
class CarouselBlock extends BlockBase {

  /**
   * {@inheritDoc}
   */
  public function build() {
    return [
      '#theme' => 'carousel',
    ];
  }

}
