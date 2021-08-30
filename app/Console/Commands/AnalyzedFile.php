<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AnalyzedFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deleteFile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $day = env('DURATION_OF_STORAGE', 365);
        $lastYear = date("Y-m-d", strtotime('-'. $day .'days'));
        $files = \App\Models\AnalyzedFile::select(['resultPath', 'filePath', 'id'])->where('uploadTime', '<' ,$lastYear)->get();
        try {
            foreach ($files as $file) {
                \Storage::disk('local')->delete('output/'.$file['resultPath']);
                \Storage::disk('local')->delete('input/'.$file['filePath']);
                $file->delete();
            }
            $this->info('Delete success');
        } catch (\Exception $e) {
            $this->error('Error ' . $e);
        }
    }
}
