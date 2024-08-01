<?php

        namespace App\Repositories\Sql;
        use App\Models\Value;
        use App\Repositories\Contract\ValueRepositoryInterface;
        use Illuminate\Database\Eloquent\Collection;

        class ValueRepository extends BaseRepository implements ValueRepositoryInterface
        {

            public function __construct()
            {

                return $this->model = new Value();

            }

        }
        