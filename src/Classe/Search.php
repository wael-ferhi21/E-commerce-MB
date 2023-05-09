<?php
 
 namespace App\Classe;

 use App\Entity\Categorie;
 use App\Entity\SousCategorie;

 class Search{
    /**
     * @var string
     */
    public $string = '';
   
    /**
     * @var Categorie[]
     */
    public $categories = [];

     /**
     * @var SousCategorie[]
     */
    public $sousCategories = [];
    
 }