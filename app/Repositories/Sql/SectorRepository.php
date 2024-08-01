<?php

        namespace App\Repositories\Sql;
        use App\Models\Sector;
        use App\Repositories\Contract\SectorRepositoryInterface;
        use Illuminate\Database\Eloquent\Collection;

        class SectorRepository extends BaseRepository implements SectorRepositoryInterface
        {

            public function __construct()
            {

                return $this->model = new Sector();

            }

        }
        