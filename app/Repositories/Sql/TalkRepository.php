<?php

        namespace App\Repositories\Sql;
        use App\Models\Talk;
        use App\Repositories\Contract\TalkRepositoryInterface;
        use Illuminate\Database\Eloquent\Collection;

        class TalkRepository extends BaseRepository implements TalkRepositoryInterface
        {

            public function __construct()
            {

                return $this->model = new Talk();

            }

        }
        