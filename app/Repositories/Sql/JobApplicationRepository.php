<?php

        namespace App\Repositories\Sql;
        use App\Models\JobApplication;
        use App\Repositories\Contract\JobApplicationRepositoryInterface;
        use Illuminate\Database\Eloquent\Collection;

        class JobApplicationRepository extends BaseRepository implements JobApplicationRepositoryInterface
        {

            public function __construct()
            {

                return $this->model = new JobApplication();

            }

        }
        