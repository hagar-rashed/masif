<?php

        namespace App\Repositories\Sql;
        use App\Models\Book;
        use App\Repositories\Contract\BookRepositoryInterface;
        use Illuminate\Database\Eloquent\Collection;

        class BookRepository extends BaseRepository implements BookRepositoryInterface
        {
            
            public function __construct()
            {

                return $this->model = new Book();

            }

        }
        