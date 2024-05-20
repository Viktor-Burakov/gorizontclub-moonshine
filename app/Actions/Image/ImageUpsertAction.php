<?php

namespace App\Actions\Image;


use App\Models\Image;
use Illuminate\Support\Carbon;

class ImageUpsertAction
{
    public function __invoke(array $data): void
    {
        $columns = [
            'name',
            'alt'
        ];;
        $upsert = array();

        foreach ($data as $index => $item) {
            $upsert[$index]['id'] = intval($item['id']);

            foreach ($columns as $column) {
                if (!isset($item[$column]) || $item[$column] === 'null') { //todo выяснить почему приходит строка
                    $upsert[$index][$column] = null;
                } else {
                    $upsert[$index][$column] = $item[$column];
                }
            }
        }

        Image::upsert(
            $upsert,
            ['id'],
            $columns
        );
    }

}
