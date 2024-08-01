<?php

        namespace App\Repositories\Sql;
        use App\Models\Scrap;
        use App\Repositories\Contract\ScrapRepositoryInterface;
        use Illuminate\Database\Eloquent\Collection;

        class ScrapRepository extends BaseRepository implements ScrapRepositoryInterface
        {

            public function __construct()
            {

                return $this->model = new Scrap();

            }

        }
        