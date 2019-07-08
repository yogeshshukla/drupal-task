<?php

namespace Drupal\task\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;
use Drupal\Core\Access\AccessResult;

/**
 * implementing our page type node response.
 */
class ResponsePageController extends ControllerBase {

	/**
	 * return node as JSON response
	 */
	public function showJsonData( $sitekey, $node ) {
		$siteapikey = \Drupal::config( 'system.site' )->get( 'siteapikey' );
		$node_data  = Node::load( $node );
			return new JsonResponse(
				[
					'data'   => [
						'title' => $node_data->get( 'title' )->value,
						'type'  => $node_data->getType(),
						'body'  => $node_data->get( 'body' )->value,
					],
					'method' => 'GET',
				]
			);
	}

  /**
	 * custom access permission
	 */
	public function access( $sitekey, $node ) {
    $siteapikey = \Drupal::config( 'system.site' )->get( 'siteapikey' );
		$node_data  = Node::load( $node );
		if ( !isset( $node_data ) || $node_data->getType() !== 'page' || $sitekey !== $siteapikey ) {
      return AccessResult::forbidden();
		}
    return AccessResult::allowed();
	}

}
