<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Str;
use Carbon\Carbon;

class UserRegistCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:user-regist';

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
     * @return mixed
     */
    public function handle()
    {
        // DB:beginTransaction();
        try {

            // ファイルの読み込み
        $file = new \SplFileObject(storage_path('app/test2.csv'));
        
        $file->setFlags(
          \SplFileObject::READ_CSV |           // CSV 列として行を読み込む
          \SplFileObject::READ_AHEAD |       // 先読み/巻き戻しで読み出す。
          \SplFileObject::SKIP_EMPTY |         // 空行は読み飛ばす
          \SplFileObject::DROP_NEW_LINE    // 行末の改行を読み飛ばす
        );

        // 各行を処理
        $records = array();
        foreach ($file as $i => $row)
        {
            // 1行目はキーヘッダ行として取り込み
            if($i===0) {
                foreach($row as $j => $col) $colbook[$j] = $col;
                continue;
            }
 
            // 2行目以降はデータ行として取り込み
            $line = array();
            foreach($colbook as $j=>$col) $line[$colbook[$j]] = @$row[$j];
            $records[] = $line;
        }
  
        $now = Carbon::now();
        // 読み込んだCSVデータをループ
        foreach ($records as $record) {
            $user_count = User::where('email',$record['メールアドレス'])->get()->count();
            if ($user_count != 0) continue;

            if (is_null($record["ログインパスワード"]))
            {
                $password = Hash::make('pass0123456789');
            }
            else
            {
                $password = Hash::make($record["ログインパスワード"]);
            }

            DB::table('users')->insert(
                [
                    'name'              => $record["氏名"],
                    'kana'              => mb_convert_kana($record["フリガナ"],'C','UTF-8'),
                    'email'             => $record["メールアドレス"],
                    'password'          => $password,
                    'remember_token'    => \Str::random(10),
                    'created_at'        => $now,
                    'updated_at'        => $now
                ]
            );
        }
 
        //DB::commit();
      } catch (Exception  $e) {

        throw $e;
      }



    }
}
