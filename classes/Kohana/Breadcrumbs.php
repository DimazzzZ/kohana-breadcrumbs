<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Breadcrumbs
{
    /**
     * Default view 
     * @var string
     */
    protected $view = 'Breadcrumbs/Default';
    
    /**
     * Singleton instance
     * @var Kohana_Breadcrumbs
     */
    protected static $instance;
    
    /**
     * Stack of breadcrumb items
     * @var array
     */
    protected $items = array();
    
    /**
     * Constructor
     * @return Kohana_Breadcrumbs
     */
    private function __construct() {}
    
    /**
     * Get the unique instance
     * @return Kohana_Breadcrumbs
     */
    public static function instance()
    {
        if(self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    /**
     * Set the template name
     * @param string $view 
     */
    public function setView($view)
    {
        $this->view = $view;
    }
    
    /**
     * Add a new item to the breadcrumb stack
     * @param string $label
     * @param string $url
     */
    public function addItem($label, $url = null)
    {
        $this->items[] = array(
            'label' => $label,
            'url'   => $url,
        );
    }
    
    /**
     * Render the breadcrumb
     * @return string
     */
    public function render()
    {
        $view = View::factory($this->view);
        $view->items       = $this->items;
        $view->items_count = count($this->items);
        
        $config = Kohana::$config->load('breadcrumbs');
        
        $view->separator     = $config['separator'];
        $view->last_linkable = $config['last_linkable'];
        
        
        return $view->render();
    }
}