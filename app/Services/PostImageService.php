<?php

namespace App\Services;


use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PostImageService
{
    private array $upsert = [];
    private string $updatedAt;
    private array $arrayIndex = [];
    private array $arrayImages = [];

    private Model $model;

    public function __construct(array $data, Model $model,array $columns = [])
    {
        $this->model = $model;
        $this->updatedAt = Carbon::now();

        foreach ($data as $index => $item) {
            $this->upsert[$index]['name'] = '';

            if (!isset($item['id'])) {
                $this->upsert[$index]['id'] = null;
            } elseif (intval($item['id']) === 0) {
                $this->upsert[$index]['id'] = null;
                $this->upsert[$index]['name'] = $item['id'];
            } else {
                $this->upsert[$index]['id'] = intval($item['id']);
            }

            foreach ($columns as $column) {
                if (!isset($item[$column])) {
                    $this->upsert[$index][$column] = null;
                } else {
                    $this->upsert[$index][$column] = $item[$column];
                }
            }

            $this->upsert[$index]['updated_at'] = $this->updatedAt;

            if (!$columns) {
                $this->arrayIndex[$item['id']] = $index;
            } else {
                $this->arrayIndex[$item['name']] = $index;
            }

            if (isset($item['images'])) {
                $this->arrayImages[$item['name']] = $item['images'];
            }
        }

        $columns[] = 'updated_at';

        $this->model->upsert(
            $this->upsert,
            ['id'],
            $columns
        );
    }

    public function getSync(): array
    {
        $dataResultArray = $this->model->select(['id', 'name'])
            ->where('updated_at', $this->updatedAt)
            ->get();

        $sync = array();

        foreach ($dataResultArray as $item) {
            if (array_key_exists($item['id'], $this->arrayIndex)) {
                $sync[$item['id']] = ['sort' => $this->arrayIndex[$item['id']]];
            } else {
                $sync[$item['id']] = ['sort' => $this->arrayIndex[$item['name']]];
                if (isset($this->arrayImages[$item['name']])) {
                    dump($this->arrayImages[$item['name']]);
                }
            }
        }


        return $sync;
    }

}
