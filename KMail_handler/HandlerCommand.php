<?php
namespace KMail_handler;
//use KMail_handler\KMailProject;
require_once 'KMail_handler/KMailProject.php';

abstract class HandlerCommand
{
    
    protected  $project;
    
    public  function __construct( $project)
    {
        $this->project = $project;
    }
}

