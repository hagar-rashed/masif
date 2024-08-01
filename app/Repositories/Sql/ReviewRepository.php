<?php

        namespace App\Repositories\Sql;
        use App\Models\Review;
        use App\Repositories\Contract\ReviewRepositoryInterface;
        use Illuminate\Database\Eloquent\Collection;

        class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
        {

            public function __construct()
            {

                return $this->model = new Review();

            }

        }