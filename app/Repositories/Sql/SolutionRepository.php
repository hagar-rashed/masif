<?php

        namespace App\Repositories\Sql;
        use App\Models\Solution;
        use App\Repositories\Contract\SolutionRepositoryInterface;
        use Illuminate\Database\Eloquent\Collection;

        class SolutionRepository extends BaseRepository implements SolutionRepositoryInterface
        {

            public function __construct()
            {

                return $this->model = new Solution();

            }

        }
        