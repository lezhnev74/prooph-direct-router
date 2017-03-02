<?php
namespace DirectRouterTests\TestCommand;

class TestCommand
{
    private $data;
    
    /**
     * TestCommand constructor.
     *
     * @param $data
     */
    public function __construct($data) { $this->data = $data; }
    
    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
    
    
}