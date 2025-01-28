<?php

namespace app\controllers;

use app\controllers\AppController;
use app\db_models\Category;
use app\db_models\Post;
use DI\Attribute\Inject;
use pronajem\libs\PaginationSetParams;


class BlogController extends AppController
{
    #[Inject]
    private Post $post;

    #[Inject]
    private PaginationSetParams $pagination;

    #[Inject]
    private Category $category;

    public function indexAction(){


        $this->setMeta('Blog', 'Članky');

        $postModel = $this->post;

        $posts = $this->post->getAllPosts(3);

        $pagination = $this->pagination;

        $categories = $this->category->getAllCategories();

        $this->set(compact('posts', 'pagination', 'postModel', 'categories'));

    }

    public function singleAction()
    {

        $uri = $_SERVER['REQUEST_URI'];
        $slug = $this->post->getSlug($uri);
        $post = $this->post->getOnePostBySlug($slug);

        if(!$post){
            throw new \Exception('Stránka nenalezena', 404);
        }

        $this->setMeta($post->title, $post->description);
        $this->set(compact('post'));

    }

    public function categoryAction(){

        $uri = $_SERVER['REQUEST_URI'];
        $slug = $this->category->getSlug($uri);
        $category = $this->category->getOneCategoryBySlug($slug);

        if(!$category){
            throw new \Exception('Stránka nenalezena', 404);
        }

        $postModel = $this->post;

        $pagination = $this->pagination;

        $categoryId = $category->id;

        $categoryPosts = $this->post->getAllPostsByCategory($categoryId, 2);

        $categories = $this->category->getAllCategories();

        $this->setMeta($category->title, 'Články v kategorii');
        $this->set(compact('categoryPosts', 'category', 'pagination', 'postModel', 'categories', 'categoryId'));
    }


}