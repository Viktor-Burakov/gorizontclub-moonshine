<?php

namespace App\Services;



use App\Models\ContentBlock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ContentUpsertAndSyncService
{
    private static array $columns = [
        'name',
        'title',
        'description'
    ];
    private array $upsert = [];
    private string $updatedAt;
    private array $arrayIndex = [];
    private array $arrayImages = [];
    private Model $model;

    public function __construct(array $data, Model $model,array $columns = [])
    {

        $this->updatedAt = Carbon::now();

        foreach ($data as $index => $item) {

            if (!isset($item['id'])) {
                $this->upsert[$index]['id'] = null;
            } else {
                $this->upsert[$index]['id'] = intval($item['id']);
            }

            foreach (self::$columns as $column) {
                if (!isset($item[$column])) {
                    $this->upsert[$index][$column] = null;
                } else {
                    $this->upsert[$index][$column] = $item[$column];
                }
            }

            $this->upsert[$index]['updated_at'] = $this->updatedAt;

            $this->arrayIndex[$item['name']] = $index;
        }

        self::$columns[] = 'updated_at';

        ContentBlock::upsert(
            $this->upsert,
            ['id'],
            self::$columns
        );
    }
    public function getSync():array
    {
        $dataResultArray = ContentBlock::select(['id', 'name'])
            ->where('updated_at', $this->updatedAt)
            ->get();

        $sync = array();

        foreach ($dataResultArray as $item) {
            $sync[$item['id']] = ['sort' => $this->arrayIndex[$item['name']]];
        }

        return $sync;
    }

}
