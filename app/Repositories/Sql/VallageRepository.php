<?php

        namespace App\Repositories\Sql;
        use App\Models\village;
        use App\Repositories\Contract\VallageRepositoryInterface;
        use Illuminate\Database\Eloquent\Collection;

        class VallageRepository extends BaseRepository implements VallageRepositoryInterface
        {

            public function __construct()
            {

                return $this->model = new village();

            }

        }