<?php

        namespace App\Repositories\Sql;
        use App\Models\Video;
        use App\Repositories\Contract\VideoRepositoryInterface;
        use Illuminate\Database\Eloquent\Collection;

        class VideoRepository extends BaseRepository implements VideoRepositoryInterface
        {
            
            public function __construct()
            {

                return $this->model = new Video();

            }

        }
        