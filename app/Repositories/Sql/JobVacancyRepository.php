<?php

        namespace App\Repositories\Sql;
        use App\Models\JobVacancy;
        use App\Repositories\Contract\JobVacancyRepositoryInterface;
        use Illuminate\Database\Eloquent\Collection;

        class JobVacancyRepository extends BaseRepository implements JobVacancyRepositoryInterface
        {

            public function __construct()
            {

                return $this->model = new JobVacancy();

            }

        }
        