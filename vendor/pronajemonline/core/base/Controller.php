<?php

namespace pronajem\base;

use pronajem\App;
use pronajem\Registry;


abstract class Controller
{


    /**
     * @var array $data An associative array that stores the data to be passed from the controller to the view.
     * This data is extracted into variables within the view, allowing dynamic content rendering.
     */
    protected $data = [];

    /**
     * @var array $meta Contains meta information for the webpage, such as 'title', 'desc' (description),
     * and 'keywords'. These are important for SEO and are used to populate the meta tags in the view's HTML head section.
     */
    protected $meta = ['title'=>'','desc'=>'', 'keywords'=>''];

    /**
     * @var string|null $layout Specifies the layout file to be used when rendering the view.
     * If null or not set, a default layout may be used. This allows for flexible page layouts across different parts of the application.
     */
    public $layout;


    public function getView(string $view){

        $viewObject = new View($this->meta, $this->layout, $view);

        $viewObject->render($this->data);

    }

    /**
     * Sets the data to be passed to the view.
     *
     * This method is used to pass data from the controller to the view. The data is compacted into an array
     * in the derived controllers and then set to this controller's data property. The View::render method will
     * later extract these data into variables, making them accessible within the view file. This mechanism
     * facilitates the transfer of data from the controller to the view, enabling dynamic content rendering
     * based on the data provided by the controller.
     *
     * @param array $data An associative array of data to be passed to the view.
     */
    public function set($data) {
        $this->data = $data;
    }

    /**
     * Sets the meta information for the view.
     *
     * This method is utilized to define meta information such as the title, description, and keywords
     * of the webpage. These meta details are crucial for SEO and provide context about the content
     * of the page to search engines and social media platforms. The meta information is stored in
     * the controller's meta property and can be accessed within the view to populate the corresponding
     * meta tags in the HTML head section.
     *
     * @param string $title The title of the webpage.
     * @param string $desc The description of the webpage content.
     * @param string $keywords Comma-separated keywords related to the webpage content.
     */
    public function setMeta($title = '', $desc = '', $keywords = ''){
        $this->meta['title'] = $title;
        $this->meta['desc'] = $desc;
        $this->meta['keywords'] = $keywords;
    }

}