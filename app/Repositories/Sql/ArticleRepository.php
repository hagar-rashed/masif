<?php

        namespace App\Repositories\Sql;
        use App\Models\Article;
        use App\Repositories\Contract\ArticleRepositoryInterface;
        use Illuminate\Database\Eloquent\Collection;

        class ArticleRepository extends BaseRepository implements ArticleRepositoryInterface
        {
            
            public function __construct()
            {

                return $this->model = new Article();

            }

        }
        