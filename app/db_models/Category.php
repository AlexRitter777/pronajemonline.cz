<?php

namespace app\db_models;

use app\models\AppModel;
use pronajem\libs\PaginationSetParams;
use RedBeanPHP\R;

class Category extends AppModel
{
    public function __construct(PaginationSetParams $pagination)
    {

        $this->pagination = $pagination;

        parent::__construct($pagination);

    }

    public function getAllCategories()
    {
        return R::FindAll($this->table);
    }

    public function getOneCategoryBySlug(string $slug) {

        return R::findOne($this->table, 'slug=?',[$slug]);

    }

    public function getCategoryPosts(int $categoryId) {

        $category = R::load($this->table, $categoryId);

        return $category->ownPostList;

    }

}