<?php
// @codingStandardsIgnoreFile

namespace Jnjxp\Mockup;

use Zend\Diactoros\Response as Response;
use Zend\Diactoros\ServerRequestFactory as ServerRequestFactory;

class Mockup
{
   protected $router;

   public function __construct(
       $router,
       $send,
       $view,
       $factory
   ) {
       $this->map = $router->getMap();
       $this->matcher = $router->getMatcher();
       $this->view = $view;
       $this->send = $send;
       $this->factory = $factory;
   }

   public function views($path)
   {
       $this->view->getViewRegistry()->appendPath($path);
   }

   public function layouts($path)
   {
       $this->view->getLayoutRegistry()->appendPath($path);
   }

   public function getView()
   {
       return $this->view;
   }

   public function mock($name, $data = null)
   {
       $responder = [$this, 'respond'];

       $route = $this->map
           ->get($name, '/' . $name, $responder)
           ->defaults(
               [
                   'view' => $name,
                   'data' => $data
               ]
           );

       return $route;
   }

   public function respond($request, $response)
   {
        $script = $request->getAttribute('view');
        $data = $request->getAttribute('data', []);
        $data = $this->getData($data);

        $view = $this->view;

        $view->addData($data);
        $view->setView($script);

        $response->getBody()->write($view());

        return call_user_func($this->send, $response);
   }

   /**
    * GetData
    *
    * @param mixed $spec DESCRIPTION
    *
    * @return mixed
    *
    * @access protected
    */
   protected function getData($spec)
   {
       if (is_string($spec)) {
           $spec = $this->factory->newInstance($spec);
       }

       if (is_callable($spec)) {
           $spec = $spec();
       }

       return $spec;
   }

   public function __invoke()
   {
       $request = ServerRequestFactory::fromGlobals();

       $route = $this->matcher->match($request);
       if (! $route) {
           echo "<h1>Invalid Route</h1>";
           var_dump($this->matcher->getFailedRoute());
           return;
       }

       try {
            foreach ($route->attributes as $key => $val) {
                $request = $request->withAttribute($key, $val);
            }
            $handler = $route->handler;
            return $handler($request, new Response);
       } catch (\Exception $e) {
           echo sprintf('%s: %s', get_class($e), $e->getMessage());
       }

   }

}
