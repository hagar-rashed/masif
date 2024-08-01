<?php

        namespace App\Repositories\Sql;
        use App\Models\About;
        use App\Repositories\Contract\AboutRepositoryInterface;
        use Illuminate\Database\Eloquent\Collection;

        class AboutRepository extends BaseRepository implements AboutRepositoryInterface
        {

            public function __construct()
            {

                return $this->model = new About();

            }

        }
        