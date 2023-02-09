<?php

namespace App\Jobs;

use App\Models\File;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Scalar\String_;
use Smalot\PdfParser\Parser;

class FileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public mixed $path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
        public function __construct($path, public String $file_name, public String $file_type, public User $user)
    {
        $this->path=$path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($this->path);
        $text = $pdf->getText();

        File::create([
            'doc_content'=>$text,
            'doc_name'=>$this->file_name,
            "doc_type"=>$this->file_type,
            "user_id"=>$this->user->id
        ]);


    }
}
