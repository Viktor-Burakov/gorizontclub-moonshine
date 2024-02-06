<?php

namespace App\Services;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PostContentService
{
    private array $arrayIndex;
    private array $upsert = [];
    private string $updatedAt;

    public Model $model;

    public string $secIndexColumn;

    public function __construct(array $data, Model $model, array $columns, string $secIndexColumn = 'name')
    {
        $this->model = $model;
        $this->secIndexColumn = $secIndexColumn;
        $this->updatedAt = Carbon::now();

        foreach ($data as $index => $item) {
            $this->upsert[$index][$secIndexColumn] = '';

            if (!isset($item['id'])) {
                $this->upsert[$index]['id'] = null;
            }elseif (intval($item['id']) === 0) {
                $this->upsert[$index]['id'] = null;
                $this->upsert[$index][$secIndexColumn] = $item['id'];
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

            if (!$columns){
                $this->arrayIndex[$item['id']] = $index;
            } else {
                $this->arrayIndex[$item[$secIndexColumn]] = $index;
            }
        }

        $columns[] = 'updated_at';

        $this->model->upsert(
            $this->upsert,
            ['id'],
            $columns
        );
    }
    public function getSync():array
    {
        $dataResultArray = $this->model->select(['id', $this->secIndexColumn])
            ->where('updated_at', $this->updatedAt)
            ->get();

        $sync = array();

        foreach ($dataResultArray as $item) {

            if (array_key_exists($item['id'], $this->arrayIndex)) {
                $sync[$item['id']] = ['sort' => $this->arrayIndex[$item['id']]];
            }else{
                $sync[$item['id']] = ['sort' => $this->arrayIndex[$item[$this->secIndexColumn]]];
            }
        }

        return $sync;
    }

}
