<?php

namespace App\Actions\Image;


use App\Models\Image;
use Illuminate\Support\Carbon;

class ImageUpsertAndSyncAction
{
    public function __invoke(array $data): array
    {
        $updatedAt = Carbon::now();

        $upsert = array();
        $arrayIndex = array();

        foreach ($data as $index => $item) {
            $upsert[$index]['name'] = '';

            if (intval($item['id']) === 0) {
                $upsert[$index]['id'] = null;
                $upsert[$index]['name'] = $item['id'];
            } else {
                $upsert[$index]['id'] = intval($item['id']);
            }

            $upsert[$index]['updated_at'] = $updatedAt;

            $arrayIndex[intval($item['id'])] = $index;
        }

        $columns[] = 'updated_at';

        Image::upsert(
            $upsert,
            ['id'],
            $columns
        );


        $dataResultArray = Image::select(['id', 'name'])
            ->where('updated_at', $updatedAt)
            ->get();

        $sync = array();
        dump($upsert);
        dump($arrayIndex);
            foreach ($dataResultArray as $item) {
                dump($item);
            if (array_key_exists($item['id'], $arrayIndex)) {
                $sync[$item['id']] = ['sort' => $arrayIndex[$item['id']]];
            } else {


                $sync[$item['id']] = ['sort' => $arrayIndex[$item['name']]];
            }
        }

        return $sync;
    }

}
