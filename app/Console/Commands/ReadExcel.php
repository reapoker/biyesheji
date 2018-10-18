<?php
/**
 * Created by PhpStorm.
 * User: reapo
 * Date: 2018/6/16
 * Time: 16:08
 */
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


    class ReadExcel extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'ReadExcel';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = '读取excel文件中的数据';

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
         * @return mixed
         */
        public function handle()
        {
            $filePath = 'storage/Excel/weichouqian/21afternoon/01-小学男子乙组五步拳70.xlsx';
            //$data=[];
            Excel::load($filePath, function($reader) {
                $data = $reader->all();
                $data=all_to_array($data);
                $data=$data[0];
//                dd($data);
                foreach ($data as $k => $v){
                    //$col = $v;
                    $col = [
                        'name' => '测试'.$v['序号'],
                        //'sex' => '女',
                        'zubie' => '测试项目',
                        'danwei' => '测试用团体',
                        'order_id' => $v['序号']
                    ];
//                    var_dump($col);
                    $db = DB::table('bs_yundongyuan')->insert($col);
                }
            });
        }
    }