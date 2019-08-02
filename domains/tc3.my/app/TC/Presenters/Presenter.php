<?php namespace TC\Presenters;


/**
* 
*/
class Presenter
{
    
    protected $resource;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public __get($name) {
        if(method_exists($this , $name)) {
            return $this->{name}();
        }
        return $this->resource->{$name};
    }


}

/**
* 
*/
class PresenterCollection extends Illuninate/Support/Collection
{
    
    function __construct($presenter, Illuminate\Support\Colection $collection)
    {
        foreach ($colection as $key => $resource) {
            $collection put($key, new $presenter($resource));
            # code...
        }
    }

    $this->items = $collection->toArray();
}