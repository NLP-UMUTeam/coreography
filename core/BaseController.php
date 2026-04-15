<?php

namespace CoreOGraphy;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;



/**
 * BaseController
 *
 * @package Core-o-Graphy
 */
abstract class BaseController {

    /** @var mixed */
    protected $_request;
    
    
    /** @var mixed */
    protected $_template;
    
    
    /** @var mixed */
    protected $_container;
    
    
    /** @var \Psr\Http\Message\ResponseInterface */
    protected $_response;
    
    
    /**
     * handleRequest
     *
     * This method has to be implemented by the controllers
     *
     * @package Core-o-Graphy
     */
    
    public abstract function handleRequest ();
    
    
    
    /**
     * __construct
     *
     * @package Core-o-Graphy
     */
    public function __construct () {
        
        // Reference container
        global $container;
        
        
        // Store
        $this->_container = $container;
        
        
        // Create the request
        $this->_request = ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        );
        
       
        // Get class info for the current controller
        $class_info = new \ReflectionClass ($this);
        $class_path = dirname ($class_info->getFileName()); 
        $class_path = str_replace (getcwd (), '', $class_path);
        $class_path = trim ($class_path, '/');
        
        
        // Fetch template system
        if ($container['templates']) {
        
            $twig = $container['templates'];
            $loader = $container['loader'];
            $loader->addPath ($class_path . '/templates/');

            // Store
            $this->_template = $twig;
        
        }
        
        
        // Create response
        $this->_response = new Response ();

    }
    
    
    /**
     * Return decoded JSON payload from php://input.
     */
    public function getRequestPayload(): array {
        global $container;

        if (!isset($container['payload'])) {
            $rawPayload = file_get_contents('php://input');
            $decoded = json_decode($rawPayload ?: '', true);

            $container['payload'] = is_array($decoded) ? $decoded : [];
        }

        return $container['payload'];
    
    }
    
    
    /**
     * Set a JSON response.
     */
    public function setJSONResponse (array $response, int $statusCode = 200): void {
        $jsonResponse = new JsonResponse (
            $response,
            $statusCode,
            ['Content-Type' => 'application/json; charset=utf-8']
        );

        $this->_response = $jsonResponse->withEncodingOptions (
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );
    }
    
    
    /**
     * Execute controller and emit response.
     */
    public function handle (): void {
        $this->handleRequest( );

        $emitter = new SapiEmitter ();
        $emitter->emit ($this->_response);
    }
    
}
