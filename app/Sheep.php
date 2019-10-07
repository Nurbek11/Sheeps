<?php


namespace App;


use Illuminate\Support\Facades\DB;

class Sheep
{
    const NumberToBreeding = 2;
    const MinSheepfold = 1;
    const MaxSheepfold = 4;


    public static function add($sheepfold)
    {
        $id = false;
        if (abs($sheepfold) > 0) {
            $id = DB::table('sheep')->insertGetId(['sheepfold' => $sheepfold]);

        }
    }

    public static function isSheepfoldEmpty()
    {
        $sheep = DB::table('sheep')->latest()->first();
        return empty($sheep->id);
    }

    public static function reset()
    {
        DB::table('sheep')->truncate();

    }

    public static function euthanize($sheepfold = false)
    {
        if (abs($sheepfold) > 0) {
            $sheep = DB::table('sheep')->where([['sheepfold', '=', $sheepfold], ['active', '=', '1']])->first();
        } else {
            $sheep = DB::table('sheep')
                ->select('id', DB::raw('COUNT(id) as my'))
                ->where('active', '1')
                ->groupBy('sheepfold')
                ->havingRaw('COUNT(id) > 1')->inRandomOrder()->first();
        }

        if (!empty($sheep->id)) {
            DB::table('sheep')->where('id', $sheep->id)->update(['active' => 0]);

        }

        return empty($sheep->id) ? 0 : $sheep->id;
    }

    public static function checkSheepfold(){
        $padList = [];

        for ( $i = Sheep::MinSheepfold; $i <= Sheep::MaxSheepfold; $i++ ) {
            $padList[$i] = DB::table('sheep')->where([['sheepfold', '=', $i], ['active', '=', '1']])->count();
        }

        $max = array_search(max($padList), $padList);
        $min = array_search(min($padList), $padList);

        $total = min($padList);

        if ( $min != $max && $total === 1 ) {
            $id  = Sheep::move($max, $min);
            $msg = ['id' => $id, 'from' => $max, 'to' => $min];
        } else {
            $msg = ['none'];
        }

        return $msg;
    }

    public static function move($from, $to){
        $sheep = DB::table('sheep')->where([['sheepfold', '=', $from], ['active', '=', '1']])->latest()->first();

        DB::table('sheep')->where('id', $sheep->id)->update(['sheepfold' => $to]);

        return $sheep->id;
    }

}
