<?php

namespace App\Trait;


use App\Models\File;
use Carbon\Carbon;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\Object_;
use function PHPUnit\Framework\throwException;

trait Searchable
{
    /**
     * @param Client $client
     * @param $query
     * @param $index
     * @param $date
     * @return \Illuminate\Support\Collection
     */
    public function search(Client $client, $query, $index, $date): \Illuminate\Support\Collection
    {
        $params = [
            'index' => $index,
            'body' => [
                'query' => [
                    "bool"=>[
                        "must"=>[
                            'multi_match' =>[
                                "query"=>$query,
                                "fields"=>array_merge(
                                    $this->getFillable(),
                                    ['user','updated_at']
                                )
                            ]
                        ],
                        "filter"=>[
                            "range"=>[
                                "updated_at"=>[
                                    "lte"=>(!$date)?Carbon::now():$date
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $results = $client->search($params);

        return collect($results['hits']['hits'])->map(function ($data) {
            return new File($data['_source']);
        });
    }

    /**
     * @param Client $client
     * @param $index
     * @return array|callable|void
     */
    public function index(Client $client, $index)
    {
        $params = [
            'index' => $index,
            "type"=>"_doc",
            'id' => $this->toArray()['id'],
            'body' => array_merge(
                $this->toArray(),
                [
                    'upload_at'=>$this->toArray()['created_at'],
                    'user'=>"13"
                ]
            )
        ];
        try {
            return  $client->index($params);
        } catch (\Exception $exception) {
            throwException($exception);
        }
    }


    /**
     * @param Client $client
     * @param $params
     * @return array
     */
    public function mapping(Client $client, $params): array
    {
        return $client->indices()->create($params);
    }

    /**
     * @param Client $client
     * @return callable|array
     * delete an index
     */
    public function delete_index(Client $client): callable|array
    {
        $params = [
            'index' => $this->index,
            'id' => $this->id,
            'type'=>'_doc'
        ];
         return $client->delete($params);
    }




}
