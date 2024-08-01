<?php

        namespace App\Repositories\Sql;
        use App\Models\Brand;
        use App\Repositories\Contract\BrandRepositoryInterface;
        use Illuminate\Database\Eloquent\Collection;

        class BrandRepository extends BaseRepository implements BrandRepositoryInterface
        {

            public function __construct()
            {

                return $this->model = new Brand();

            }

        }
        