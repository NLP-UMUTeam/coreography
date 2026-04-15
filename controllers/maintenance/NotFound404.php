<?php

use \CoreOGraphy\BaseController;


/**
 * NotFound404
 *
 * This controllers represents the 404 responses.
 *
 * @package Core-o-Graphy
 */
class NotFound404 extends BaseController {

    /**
     * handleRequest
     *
     * @package Core-o-Graphy
     */
    public function handleRequest () {
        $this->setJSONResponse (['message' => 'Method not found'], 404);
    }
}
