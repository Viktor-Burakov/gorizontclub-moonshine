<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Enums\PostEnum;
use App\Models\ContentBlock;
use App\Models\Post;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PostContentUpsertAction
{
    public function __invoke(array $data, Model $model, array $columns, string $secIndexColumn = 'name'): array
    {
        $arrayIndex = array();
        $upsert = array();
        $updatedAt = Carbon::now();

        foreach ($data as $index => $item) {
            if (!isset($item['id'])) {
                $upsert[$index]['id'] = null;
            } elseif (!is_int($item['id'])) {
                $upsert[$index][$secIndexColumn] = $item['id'];
            }

            foreach ($columns as $column) {
                if (!isset($item[$column])) {
                    $upsert[$index][$column] = null;
                }
            }

            $upsert[$index]['updated_at'] = $updatedAt;

            $arrayIndex[$item[$secIndexColumn]] = $index;
        }

        $columns[] = 'updated_at';
        dump($upsert);
        $model->upsert(
            $upsert,
            ['id'],
            $columns
        );
        $dataResultArray = $model->select('id', $secIndexColumn)
            ->where('updated_at', $updatedAt)
            ->get();

        $sync = array();
        foreach ($dataResultArray as $item) {
            $sync[$item['id']] = ['sort' => $arrayIndex[$item[$secIndexColumn]]];
        }

        return $sync;
    }
}
