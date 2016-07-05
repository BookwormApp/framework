<?php 

namespace Bookworm\Projects;

trait UrlGenerator {

    public function url()
    {
        $args = func_get_args();

        if ( empty($args) ) {
            return $this->buildUrl();
        }

        if ( ! is_object($args[0]) ) {
            return $this->buildUrl(implode('/',$args));
        }

        switch ( get_class($args[0]) ) {
            case 'Bookworm\Cases\ProjectCase':
                $prefix = 'cases/'.$args[0]->ref;
                break;
            default:
                throw new \Exception('Invalid url parameter - ' . get_class($args[0]) );
        }

        $suffix = ( count($args) > 1 ? '/'.implode('/', array_slice($args, 1)) : '' );

        return $this->buildUrl($prefix.$suffix);
    }

    private function buildUrl($path = null)
    {
        return url(rtrim($this->getUrl().'/'.$path,'/'));
    }

    abstract function getUrl();

}