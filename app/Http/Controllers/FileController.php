<?php

namespace App\Http\Controllers;

use App\Jobs\FileJob;
use App\Models\File;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    //
    public String $index="leyton";
    public String $type="leyton-type";


    /**
     * @return mixed
     */
    public function create_mapping(): mixed
    {
        $params = [
            'index' => $this->index,
            'body' => [
                'mappings' => [
                        'dynamic' => "strict",
                        'properties' => [
                            'user' => [
                                'type' => 'keyword'
                            ],
                            'name' => [
                                'type' => 'text'
                            ],
                            'doc_content'=>[
                              'type'=>'text'
                            ],
                            'doc_name' => [
                                'type' => 'text'
                            ],
                            'doc_type' => [
                                'type' => 'keyword'
                            ],
                            'created_at' => [
                                'type' => 'date'
                            ],
                            'updated_at' => [
                                'type' => 'date'
                            ],
                            'uploaded_at' => [
                                'type' => 'date'
                            ]
                        ]

                ]
            ]
        ];
        return app('elasticsearch')->indices()->create($params);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'file'=>"required | file"
        ]);
        $file = $request->file('file');
        $fileName = time().'.'.$file->extension();
        $path=$file->storeAs('public/files', $fileName);
        $path=Storage::url($path);
        FileJob::dispatch($path, $fileName, $file->extension(), Auth::user());
        return redirect()->route('dashboard');
    }


    /**
     * @param Request $request
     * @return Factory|View|Application
     */
    public function index(Request $request): Factory|View|Application
    {
        $file=new File;
        return view('dashboard', [
            'files'=>($request->has('q'))? $file->search(app('elasticsearch'), $request->q, $file->index,''):File::all()
        ]);
    }

    /**
     * @param File $file
     * @return RedirectResponse
     */
    public function delete(File $file): RedirectResponse
    {
        $file->delete();
        return redirect()->route('dashboard');
    }





}
